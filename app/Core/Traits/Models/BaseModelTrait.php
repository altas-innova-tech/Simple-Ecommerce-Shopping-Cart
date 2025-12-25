<?php

namespace App\Core\Traits\Models;

use App\Core\Constants\PermissionConstants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait BaseModelTrait {
    protected static function boot() : void {
        parent::boot();

        static::creating(function ($model) {
            self::generate_model_key($model);
        });
    }



    protected static function generate_model_key($model) : void {
        //==============================================================================================================
        // verify if model already have a key
        //==============================================================================================================
        if ($model->key) {
            return;
        }


        //==============================================================================================================
        // get <Model_instance>
        //==============================================================================================================
        $class_name = static::class;


        //==============================================================================================================
        // Random <key> for <Model_instance>
        //==============================================================================================================
        $key = Str::random(32);


        //==============================================================================================================
        // verify key already generated
        //==============================================================================================================
        $key_already_exist = $class_name::where("key", $key)
                                        ->first();


        //==============================================================================================================
        // if <key_generated> already exist, we generate new <key>
        //==============================================================================================================
        if ($key_already_exist) {
            self::generate_model_key($model);
        }


        //==============================================================================================================
        // return <key_generated>
        //==============================================================================================================
        $model->key = $key;
    }



    protected function scopeListForSelect(Builder $query, string $value = "id", string $label = "label") : Builder {
        return $query->selectRaw("$value as value")
                     ->selectRaw("$label as label");
    }

    public function scopeSearch(Builder $query, string $search_text) : void {
        $model_table = $this->getTable();
        $columns     = Schema::getColumnListing($model_table);

        $query->where(function ($query) use ($columns, $search_text) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$search_text}%");
            }
        });
    }



    public static function find_by_key(string $key) {
        $item_key = static::where("key", $key)
                          ->first();

        return $item_key;
    }



    public static function find_by_keys(array $keys) {
        $item_keys = static::whereIn("key", $keys);

        return $item_keys;
    }






    public static function get_name_from_class() : string {
        return explode("\\", static::class)[4];
    }



    public static function get_table_name(bool $plural = false) : string {
        $table_name = (new static())->table;

        if ($plural) {
            return Str::plural($table_name);
        }

        return $table_name;
    }

}
