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
     * @param string $provider: GitHub | Facebook | Twitter
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $provider: GitHub | Facebook | Twitter
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
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