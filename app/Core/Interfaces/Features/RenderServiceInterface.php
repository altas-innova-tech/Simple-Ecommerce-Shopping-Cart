<?php

namespace App\Core\Interfaces\Features;

use App\Core\Base\Builders\Table\ColumnBuilder;
use App\Core\Base\Builders\Table\TableBuilder;

interface RenderServiceInterface {
    public static function get_controller_class() : string;


    public static function get_columns() : ColumnBuilder;



    public static function get_table_builder(array $params = []) : TableBuilder;



    public static function get_title_page_class() : string;
}
