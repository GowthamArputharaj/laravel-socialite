<?php

use App\Http\Controllers\Auth\SocialAccountController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
//
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/test', function() {
    $test = [];
    $test[] = Hash::make('12345678');
    $test[] = Hash::check('12345678', $test[0]);
    dd($test);

});
Route::get('login/{provider}', 'App\Http\Controllers\Auth\SocialAccountController@redirectToProvider')->name('redirectToProvider');

Route::get('login/{provider}/callback', 'App\Http\Controllers\Auth\SocialAccountController@handleProviderCallback');

