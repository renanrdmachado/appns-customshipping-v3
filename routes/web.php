<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\ShippingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/install', [BasicController::class, 'install']);
Route::get('/dashboard', [BasicController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/account/password', function () { return view('pages/account/password'); })->middleware(['auth'])->name('pass');
Route::get('/account/delete', [AccountController::class, 'AccountDelete'])->middleware(['auth'])->name('delete');
Route::post('/account/password', [AccountController::class, 'AccountPasswordUpdate'])->middleware(['auth'])->name('pass.update');

// Account
Route::get('/account/my-account', function () { return view('pages/account/my-account'); })->middleware(['auth'])->name('my-account');
Route::get('/account/subscriptions', [SubscriptionsController::class, 'SubscriptionsPageEditor'])->middleware(['auth'])->name('subscriptions');
Route::post('/account/subscriptions', [SubscriptionsController::class, 'SubscriptionsPageEditorNew'])->middleware(['auth'])->name('subscriptions');
Route::get('/account/subscriptions/refresh', [SubscriptionsController::class, 'SubscriptionsRefresh'])->name('subscriptions.refresh');

// Shipping
Route::get('/shipping', [ShippingsController::class, 'index'])->middleware(['auth'])->name('shipping');
Route::post('/shipping', [ShippingsController::class, 'save'])->middleware(['auth'])->name('shipping');
Route::get('/shipping/{id}', [ShippingsController::class, 'single'])->middleware(['auth'])->name('shipping.single');
Route::post('/shipping/response', [ShippingsController::class, 'find']);
Route::post('/shipping/import', [ShippingsController::class, 'importCSV']);
require __DIR__.'/auth.php';
