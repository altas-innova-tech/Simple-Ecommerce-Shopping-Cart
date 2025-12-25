<?php

namespace App\Features\Order\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Observers\OrderObserver;
use App\Features\Order\RenderServices\OrderConstantsTrait;
use App\Models\User;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    //==================================================================================================================
    // Scopes
    //==================================================================================================================
    protected function scopeByUser(Builder $query) : void {
        if (is_member()) {
            $query->where('user_id', user_id());
        }
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
            Constants::label => 1,
            Constants::color => ColorConstants::green,
        ];
    }



    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return "";
    }
}
