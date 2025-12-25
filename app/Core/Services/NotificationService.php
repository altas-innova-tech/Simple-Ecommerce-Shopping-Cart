<?php

namespace App\Core\Services;

use Illuminate\Http\RedirectResponse;

class NotificationService {
    private static function add_toast($type, $message, $title = null) {
        // Get existing toasts from session or initialize empty array
        $toasts = session()->get('toasts', []);

        // Add new toast to the array
        $toasts[] = [
            'type'    => $type,
            'message' => $message,
            'title'   => $title,
        ];

        // Store back to session
        session()->flash('toasts', $toasts);
    }



    public static function success($message, $title = null) : void {
        self::add_toast('success', $message, $title);
    }



    public static function error($message, $title = null) : void {
        self::add_toast('error', $message, $title);
    }



    public static function error_to_list(string $feature, $message, $title = null) : RedirectResponse {
        static::error($message, $title);

        return FeaturesService::redirect_to_list($feature);
    }



    public static function warning($message, $title = null) : void {
        self::add_toast('warning', $message, $title);
    }



    public static function info($message, $title = null) : void {
        self::add_toast('info', $message, $title);
    }



    // Optional: Method to clear all toasts
    public static function clear() : void {
        session()->forget('toasts');
    }
}
