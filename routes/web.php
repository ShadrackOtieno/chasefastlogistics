<?php

use App\Http\Controllers\Admin as A;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/* ---------------------------- Front office ---------------------------- */
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/rates', [PageController::class, 'rates'])->name('rates');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServicePageController::class, 'show'])->name('services.show');

Route::get('/quote', [QuoteRequestController::class, 'create'])->name('quote.create');
Route::post('/quote', [QuoteRequestController::class, 'store'])->middleware('throttle:5,1')->name('quote.store');

Route::get('/track', [TrackingController::class, 'index'])->middleware('throttle:30,1')->name('track');

/* ----------------------------- Back office ---------------------------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [A\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [A\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [A\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [A\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('services', A\ServiceController::class)->except('show');
        Route::resource('rates', A\RateController::class)->except('show');
        Route::resource('clients', A\ClientController::class)->except('show');
        Route::resource('team', A\TeamController::class)->except('show');

        Route::resource('shipments', A\ShipmentController::class);
        Route::post('shipments/{shipment}/events', [A\ShipmentController::class, 'storeEvent'])->name('shipments.events.store');
        Route::delete('shipments/{shipment}/events/{event}', [A\ShipmentController::class, 'destroyEvent'])->name('shipments.events.destroy');

        Route::get('quotes', [A\QuoteController::class, 'index'])->name('quotes.index');
        Route::get('quotes/{quote}', [A\QuoteController::class, 'show'])->name('quotes.show');
        Route::put('quotes/{quote}', [A\QuoteController::class, 'update'])->name('quotes.update');
        Route::delete('quotes/{quote}', [A\QuoteController::class, 'destroy'])->name('quotes.destroy');

        Route::get('messages', [A\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [A\MessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [A\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [A\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [A\SettingController::class, 'update'])->name('settings.update');

        Route::get('account', [A\AccountController::class, 'edit'])->name('account.edit');
        Route::put('account', [A\AccountController::class, 'update'])->name('account.update');
    });
});
