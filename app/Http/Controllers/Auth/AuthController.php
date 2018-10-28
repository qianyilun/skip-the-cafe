<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $authUser = User::firstOrNew(['provider_id' => $user->id]);

        $authUser->name = $user->name;
        $authUser->email = $user->email;
        $authUser->remember_token = $user->token;
        $authUser->provider_id = $user->id;
        $authUser->password = 'Provider_Github';

        $authUser->save();

        auth()->login($authUser);

        return redirect('/home');
    }
}