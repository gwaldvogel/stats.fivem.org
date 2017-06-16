<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }

    /**
     * Redirect the user to the Steam authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('steam')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('steam')->user();
            $authUser = $this->findOrCreateUser($user);
            Auth::login($authUser, true);
            return redirect('/dashboard');
        } catch (Exception $e) {
            return redirect('/login');
        }
    }

    private function findOrCreateUser($steamUser)
    {
        if ($authUser = User::where('steam_id', $steamUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'nickname' => $steamUser->nickname,
            'steam_id' => $steamUser->id,
            'avatar' => $steamUser->user['avatar'],
        ]);
    }
}
