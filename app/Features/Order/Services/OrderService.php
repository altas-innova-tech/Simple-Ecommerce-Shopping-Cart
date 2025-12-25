<?php


namespace App\Features\Order\Services;


use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;

class OrderService {
    const string status_cart            = "CART";
    const string status_completed       = "COMPLETED";
    const string status_cart_color      = ColorConstants::red;
    const string status_completed_color = ColorConstants::green;

    const array status = [
        self::status_cart,
        self::status_completed,
    ];

    const array status_render = [
        self::status_cart => [
            Constants::label => self::status_cart,
            Constants::value => self::status_cart,
            Constants::color => self::status_cart_color,
        ],
        self::status_completed => [
            Constants::label => self::status_completed,
            Constants::value => self::status_completed,
            Constants::color => self::status_completed_color,
        ],
    ];



    public static function get_status_render() : array {
        return collect(self::status)
            ->map(fn($status) => [
                Constants::label => $status,
                Constants::value => $status,
            ])
            ->toArray();
    }
}
