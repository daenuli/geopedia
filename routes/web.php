<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PremiumEventController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\DiscoverController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
    // return view('welcome');
})->name('login');

Route::post('/auth', [AuthController::class, 'auth']);
Route::get('login/{provider}', [SocialController::class, 'redirectToProvider']);
Route::get('{provider}/callback', [SocialController::class, 'handleProviderCallback']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'index']);
    
    Route::get('events/data', [EventController::class, 'data'])->name('events.data');
    Route::resource('events', EventController::class);

    Route::get('discovers/data', [DiscoverController::class, 'data'])->name('discovers.data');
    Route::resource('discovers', DiscoverController::class);

    Route::get('purchases/data', [PurchaseController::class, 'data'])->name('purchases.data');
    Route::resource('purchases', PurchaseController::class);
    
    // Route::get('premium/data', [PremiumEventController::class, 'data'])->name('premium.data');
    // Route::resource('premium', PremiumEventController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
