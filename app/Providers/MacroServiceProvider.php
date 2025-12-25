<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as DatabaseBuilder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register() : void {
        //
    }



    /**
     * Bootstrap services.
     */


    public function boot() : void {
        EloquentBuilder::macro("searchQuery", function (EloquentBuilder|DatabaseBuilder $query, string $column, ?string $term, string $column_type, int $index = 0) {
            switch ($column_type) {
                case "timestamp":
                case "datetime":
                    if ($index == 0) {
                        $query->where($column, "=", $term);
                    } else {
                        $query->orWhere($column, "=", $term);
                    }
                    break;
                case "date":
                case "time":
                case "year":
                    if ($index == 0) {
                        $query->whereDate($column, "=", $term);
                    } else {
                        $query->orWhereDate($column, "=", $term);
                    }
                    break;

                case "char":
                case "varchar":
                case "text":
                case "mediumtext":
                case "longtext":
                case "string":
                    if ($index == 0) {
                        $query->where($column, "like", "%$term%");
                    } else {
                        $query->orWhere($column, "like", "%$term%");
                    }
                    break;

                case "boolean":
                case "bool":
                    if ($index == 0) {
                        $query->where($column, filter_var($term, FILTER_VALIDATE_BOOLEAN));
                    } else {
                        $query->orWhere($column, filter_var($term, FILTER_VALIDATE_BOOLEAN));
                    }
                    break;

                default:
                    if ($index == 0) {
                        $query->where($column, $term);
                    } else {
                        $query->orWhere($column, $term);
                    }
                    break;
            }
        });

        EloquentBuilder::macro("searchMulti", function (EloquentBuilder|DatabaseBuilder $query, array $columns, ?string $term) {
            if (empty($columns) || !$term) {
                return $query;
            }

            foreach ($columns as $index => $column) {
                $table_name  = $query->getModel()
                                     ->getTable();
                $column_type = Schema::getColumnType($table_name, $column);


                $query->searchQuery($query, $column, $term, $column_type, $index);
            }

            return $query;
        });
    }
}
