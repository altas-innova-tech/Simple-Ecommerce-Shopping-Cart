<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])
     ->group(function () {
         include __DIR__ . '/Features/ProductRoutes.php';
      // include __DIR__ . '/Features/CartRoutes.php.php';
     });


require __DIR__.'/settings.php';
