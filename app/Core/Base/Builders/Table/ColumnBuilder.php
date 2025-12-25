<?php

namespace App\Core\Base\Builders\Table;

use App\Core\Constants\ComponentConstants;

class ColumnBuilder {
    public array $columns = [];



    public function __construct() {
    }



    public static function new() : self {
        return new self();
    }



    public function column_id() : self {
        $this->add_column(
            ColumnItem
                ::new()
                ->name("id")
                ->label("#")
                ->component(ComponentConstants::component_text)
                ->searchable()
                ->triable()
        );

        return $this;
    }



    public function get_columns() : array {
        return collect($this->columns)
            ->map(fn($column) => $column->get())
            ->toArray();
    }



    public function add_column(ColumnItem $column) : self {
        $this->columns[] = $column->get();

        return $this;
    }



    public function get() : array {
        return $this->columns;
    }
}
