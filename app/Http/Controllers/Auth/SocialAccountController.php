<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    protected $dashboard = 'dashboard';
    protected $login = 'login';

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        if ($provider == 'facebook' && !request()->has('code') || request()->has('denied')) {
            return redirect()->route('login')->with('status', 'Something went wrong Facebook!!!');
        }
        // dd(Socialite::driver($provider), Socialite::driver($provider)->user());
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('status', 'Something went wrong exception Fb!!!');
        }
        
        // $authUser must return a User::class instance
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::loginUsingId($authUser->id, true);
        
        return redirect()->route($this->dashboard)->with('status', 'Login Success');

        // return redirect($this->redirectSocialiteTo);
    }

    public function findOrCreateUser($socialUser, $provider)
    {   
        $account = SocialAccount::where([
            'provider_name' => $provider,
            'provider_id'   => $socialUser->id ?? ''
        ])->first();
            // dump($account);
        if ($account) {
            return $account->user;
        } else {
            $user = User::where('email', $socialUser->email)->first();

            if(!$user) {
                $user = User::create([
                    'email' => $socialUser->email,
                    'name'  => $socialUser->name
                ]);
            }

            $user->social_accounts()->create([
                'provider_name' => $provider,
                'provider_id'   => $socialUser->id,
            ]);

            return $user;
        }
    }

}
