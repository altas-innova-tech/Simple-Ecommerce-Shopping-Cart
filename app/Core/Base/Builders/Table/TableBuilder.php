<?php

namespace App\Core\Base\Builders\Table;


use App\Core\Base\Builders\Filter\FilterBuilder;
use App\Core\Base\Model\BaseModel;
use App\Core\Constants\Constants;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TableBuilder {
    protected Builder|null $query;
    protected Builder|null $initial_query;
    protected array        $columns = [];
    protected Closure      $row_actions;
    protected Closure      $row_click_action;

    protected string      $session_prefix;
    protected int         $page;
    protected int         $per_page;
    protected string|null $search_text;
    protected string      $order_by        = self::default_order_by;
    protected string      $order_direction = self::default_order_direction;
    protected array       $filters = [];

    const int     default_page            = 1;
    const int     default_per_page        = 10;
    const string  default_order_by        = "id";
    const string  default_order_direction = "desc";



    private function __construct(Builder $query = null) {
        $this->query = $query;

        $this->session_prefix = 'data-table.' . Str::slug(request()->path());


        $this->page            = request()->input("page", Session::get("{$this->session_prefix}.page", self::default_page));
        $this->per_page        = request()->input("per_page", Session::get("{$this->session_prefix}.per_page", self::default_per_page));
        $this->search_text     = request()->input("search_text", Session::get("{$this->session_prefix}.search_text", null));
        $this->order_by        = request()->input("order_by", Session::get("{$this->session_prefix}.order_by", self::default_order_by));
        $this->order_direction = request()->input("order_direction", Session::get("{$this->session_prefix}.order_direction", self::default_order_direction));


        Session::put("{$this->session_prefix}.page", $this->page);
        Session::put("{$this->session_prefix}.per_page", $this->per_page);
        Session::put("{$this->session_prefix}.search_text", $this->search_text);
        Session::put("{$this->session_prefix}.order_by", $this->order_by);
        Session::put("{$this->session_prefix}.order_direction", $this->order_direction);


        // Apply order
        $this->query
            ->orderBy($this->order_by, $this->order_direction);
    }



    public static function query(Builder $query = null) : self {
        return new self($query);
    }







    public function add_columns(ColumnBuilder $columns) : self {
        $this->columns = $columns->columns;

        return $this;
    }

    public function add_filters(FilterBuilder $filters) : self {
        $mapped_filters = $filters
            ->get()
            ->map(fn($filter) => $filter->get())
            ->toArray();


        $this->filters = $mapped_filters;

        return $this;
    }


    public function get_columns() : array {
        return collect($this->columns)
            ->map(fn($column) => $column->get())
            ->toArray();
    }



    public function row_actions(callable $actions) : self {
        $this->row_actions = $actions;

        return $this;
    }



    public function row_click_action(callable $action) : self {
        $this->row_click_action = $action;

        return $this;
    }

    private function apply_filters() : void {
        $query   = $this->query;
        $filters = $this->filters;

        foreach ($filters as $filter) {
            $filter_value = request($filter['name']);

            if ($filter_value) {
                $filter_value  = str_replace(['[', ']'], "", $filter_value);
                $filter_values = explode(", ", $filter_value);

                $query->whereIn($filter['name'], $filter_values);
            }
        }
    }


    private function apply_search_filter(?string $search_text) : void {
        $searchable_columns = collect($this->columns)
            ->filter(fn($column) => $column['searchable'])
            ->map(fn($column) => $column['name'])
            ->toArray();


        if (count($searchable_columns) > 0) {
            $this->query->where(function ($query) use ($searchable_columns, $search_text) {
                $query->searchMulti($query, $searchable_columns, $search_text);
            });
        }
    }





    public function get() : array {
        // Apply search filter
        $this->initial_query = $this->query;

        if (!is_null($this->search_text)) {
            $this->apply_search_filter($this->search_text);
        } else {
            $this->query = $this->initial_query;
        }


        // Apply filters
        $this->apply_filters();

        // Paginate the query
        $paginated_query = $this->query->paginate($this->per_page, ["*"], "page", $this->page);

        $headers = $this->columns;

        return [
            "filters"         => $this->filters,
            "order_by"        => $this->order_by,
            "order_direction" => $this->order_direction,
            "headers"         => $headers,
            "items"           => collect($paginated_query->items())
                ->map(function ($row) use ($headers) {
                    return [
                        "item"         => self::process_row($headers, $row),
                        "row_actions"  => $this->row_actions ? (($this->row_actions)($row))->get() : [],
                        "click_action" => $this->row_click_action ? (($this->row_click_action)($row))->get() : null,
                    ];
                })
                ->toArray(),
            "pagination"      => [
                "current_page" => $paginated_query->currentPage(),
                "per_page"     => $this->per_page,
                "total"        => $paginated_query->total(),
                "last_page"    => $paginated_query->lastPage(),
                "pages"        => collect(range(1, $paginated_query->lastPage()))
                    ->map(fn($page) => [
                        "page"       => $page,
                        "url"        => $paginated_query->url($page),
                        "is_current" => $page === $paginated_query->currentPage(),
                    ])
                    ->toArray(),
                "urls"         => [
                    "first" => $paginated_query->url(1),
                    "prev"  => $paginated_query->previousPageUrl(),
                    "next"  => $paginated_query->nextPageUrl(),
                    "last"  => $paginated_query->url($paginated_query->lastPage()),
                ],
            ],
        ];
    }



    public static function process_row(array $headers, BaseModel $row) : array {
        foreach ($headers as $header) {
            $column      = $header[Constants::name];
            $method_name = 'get' . Str::studly($column) . 'Attributes';

            if (method_exists($row, $method_name)) {
                $row->$column = $row->$method_name();
            } elseif (method_exists($row, 'getAttribute')) {
                $row->$column = $row->getAttribute($column);
            }
        }

        return $row->toArray();
    }
}
