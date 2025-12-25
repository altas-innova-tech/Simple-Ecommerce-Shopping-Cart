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
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(OrderObserver::class)]
class Order extends BaseModel {
    use OrderConstantsTrait;
    use HasFactory;

    protected $table = FeaturesConstants::order;



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
    protected function scopeByUser(Builder $query) : void {
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


    //==================================================================================================================
    // Attributes
    //==================================================================================================================
    public function getUserRenderAttribute() : array {
        return [
            Constants::label => $this->user->label(),
            Constants::color => ColorConstants::green,
        ];
    }



    public function getProductCountRenderAttribute() : array {
        return [
            Constants::label => $this->products()
                                     ->count(),
            Constants::color => ColorConstants::green,
        ];
    }



    public function getStatusRenderAttribute() : array {
        return OrderService::status_render[$this->status];
    }



    public function getTotalRenderAttribute() : int {
        return $this->get_total();
    }



    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return "";
    }



    public function get_total() : int {
        return $this->products()
                    ->sum("price");
    }
}
