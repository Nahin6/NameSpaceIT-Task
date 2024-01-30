<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\urlController;
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
    return view('dashboard');
});

Route::controller(urlController::class)->group(function () {
    Route::post('/shorturl', 'urlShorten')->name('storeUrl');
    Route::get('/urlblocker', 'showLink')->name('urlPage');
    // Route::get('/urlblocker', 'urlPage')->name('urlPage')->middleware(
    //     ['throttle:3,1']
    // );
    Route::get('/{key}', 'redirectToOriginalUrl')->middleware('spam:3,1');
    Route::get('/login', 'loginPageLoader')->name('login');
    Route::get('/register', 'regPageLoader')->name('register');
    Route::get('/logoutt', 'logoutPageLoader')->name('logout');

    Route::view('/errorPage', 'displayErrorPage')->name('errorPage');

});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
