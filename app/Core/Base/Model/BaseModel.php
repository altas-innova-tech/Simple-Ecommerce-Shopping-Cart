<?php

namespace App\Core\Base\Model;

use App\Core\Traits\Models\BaseModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * @method static where(string $column, mixed $value)
 * @method static whereIn(string $column, mixed $value)
 * @method static whereEmail(string $email)
 * @method static whereName(string $name)
 * @method static whereKey(string $key)
 */
class BaseModel extends Authenticatable {
    use BaseModelTrait;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "email",
        "password",
        "member_type",
        "created_by_admin_id",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //        "id",
        "password",
        "remember_token",
        //        "email",
        "reset_password_token",
        "email_validation_token",
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts() : array {
        return [
            "email_verified_at" => "datetime",
            "password"          => "hashed",
        ];
    }



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



    public static function get_destroy_by_key(string $key) {
        $item_key = static::onlyTrashed()
                          ->where("key", $key)
                          ->first();

        return $item_key;
    }



    public static function get_by_key(string|null $key) {
        $item_key = static::where("key", $key)
                          ->first();

        return $item_key;
    }



    public static function get_by_keys(array $keys) {
        return static::whereIn("key", $keys);
    }


    public static function get_name_from_class() : string {
        return explode("\\", static::class)[4];
    }


    public static function get_table_name() : string {
        return (new static())->table;
    }
}
