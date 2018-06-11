<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Socialite;

class FacebookLoginController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->to('/home');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        dd($user->avatar_original ?: 'imgs/default.png');
        $avatar = $user->avatar_original ?: 'imgs/default.png';
        return User::create([
            'name'     => str_replace(" ", "-", $user->name),
            'email'    => $user->email,
            'avatar'   => $avatar,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
