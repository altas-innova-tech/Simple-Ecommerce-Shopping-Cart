<?php

namespace App\Core\Base\Builders\Filter;

use Illuminate\Support\Collection;

class FilterBuilder {
    protected Collection $filters;



    private function __construct() {
        $this->filters = collect();
    }



    public function add_filter(FilterItem $filter) : self {
        $filter_value = request($filter->name);

        if ($filter_value) {
            $filter_value = str_replace(['[', ']'], "", $filter_value);
            $filter_value = explode(", ", $filter_value);

            $filter->value($filter_value);
        }

        $this->filters->push($filter);

        return $this;
    }



    public static function new() : self {
        return new self();
    }



    public function get() : Collection {
        return $this->filters;
    }
}
