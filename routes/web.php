<?php

use App\Http\Controllers\Auth\SocialAccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

// Route::get('/auth/redirect', function () {
//     return Socialite::driver('github')->redirect();
// });

// Route::get('/auth/callback', function () {
//     $user = Socialite::driver('github')->user();

//     // $user->token
// });

Route::get('/auth/redirect', function () {
    
    // dd(Socialite::driver('github'), Socialite::driver('github')->redirect());
    try {
        $user = Socialite::driver('github')->redirect();
    } catch (Exception $e) {
        dd($e, Socialite::driver('github')->redirect());
    }
    return Socialite::driver('github')->redirect();
})->name('git.user.redirect');

Route::get('/auth/callback', function () {
    
    try {
        $user = Socialite::driver('github')->user();
    } catch (Exception $e) {
        return redirect()->route('login')->with('status', 'Something went wrong exception Github!!!');
    }
    
    // $authUser must return a User::class instance
    $authUser = (new SocialAccountController)->findOrCreateUser($user, 'github');

    Auth::loginUsingId($authUser->id, true);
    
    return redirect()->route('dashboard')->with('status', 'Login Success');

});

