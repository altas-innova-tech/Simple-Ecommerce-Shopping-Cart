<?php

namespace App\Features\Order\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Observers\OrderObserver;
use App\Features\Order\RenderServices\OrderConstantsTrait;
use App\Features\Order\Services\OrderService;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

#[ObservedBy(OrderObserver::class)]
class Order extends BaseModel {
    use OrderConstantsTrait;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $table = FeaturesConstants::order;

    protected $appends = ['total_render'];
    protected $with = ['user'];



    protected static function newFactory() {
        return OrderFactory::new();
    }


    //==================================================================================================================
    // Relations
    //==================================================================================================================
    public function user() : BelongsTo {
        return $this->belongsTo(User::class, "user_id");
    }



    public function products() : HasMany {
        return $this->hasMany(OrderProduct::class, "order_id");
    }

    //==================================================================================================================
    // Scopes
    //==================================================================================================================
    protected function scopeForMember(Builder $query) : void {
        if (is_member()) {
            $query->where('user_id', user_id());
        }
    }



    protected function scopeCart(Builder $query) : void {
        $query->where('status', OrderService::status_cart);
    }



    protected function scopeCompleted(Builder $query) : void {
        $query->where('status', OrderService::status_completed);
    }



    protected function scopeStatus(Builder $query, string $status) : void {
        $query->where('status', $status);
    }


    //==================================================================================================================
    // Attributes
    //==================================================================================================================
    public function userRender() : Attribute {
        return new Attribute(
            get: fn() => [
                Constants::label => $this->user->label(),
                Constants::color => ColorConstants::green,
            ],
        );
    }



    public function statusRender() : Attribute {
        return new Attribute(
            get: fn() => OrderService::status_render[$this->status],
        );
    }



    public function ProductCountRender() : Attribute {
        return new Attribute(
            get: fn() => [
                Constants::label => (string) $this->products()
                                                  ->count(),
                Constants::color => ColorConstants::green,
            ],
        );
    }



    public function TotalRender() : Attribute {
        return new Attribute(
            get: fn() => $this->get_total(),
        );
    }


    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return $this->user->label() ." - ". $this->status;
    }



    public function get_total() : float {
        return $this->products->sum(function ($product) {
            return $product->price * $product->quantity;
        });
    }



    public static function get_member_order_cart() : ?Order {
        return static::forMember()
                     ->cart()
                     ->first();
    }



    public static function get_member_completed_orders() : Builder {
        return static::forMember()
                     ->completed();
    }



    public static function get_member_total_cart() : string {
        $order = self::get_member_order_cart();

        if (!$order) {
            return "0";
        }

        $amount = $order->get_total();

        return number_format((float) $amount, 2, '.', ' ');
    }
}
