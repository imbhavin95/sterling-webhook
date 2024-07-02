<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RouteController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
})->name('/');


Route::post('loginProcess', [LoginController::class, 'loginProcess'])->name('loginProcess');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class,'index'])->name('home');
    Route::get('add-webhook', [RouteController::class,'index'])->name('add-webhook');
    Route::get('add-new-url/{id}', [RouteController::class,'addNewUrl'])->name('add-new-url');
    Route::post('store-webhook',[RouteController::class,'storeWebhook'])->name('store-webhook');
    Route::post('store-code',[RouteController::class,'storeCode'])->name('store-code');
    Route::delete('remove-webhook/{webhook}',[RouteController::class,'destroy'])->name('webhook-delete');
    Route::get('logout',function(){
        Auth::logout();
        return redirect()->route('/');
    })->name('logout');
});
Route::post('webhook/{id}',[RouteController::class,'compiler'])->name('webhook-post');
Route::get('webhook/{id}',[RouteController::class,'compiler'])->name('webhook-get');
