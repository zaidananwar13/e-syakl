<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /* Email Login */

    /* Google API */
    public function redirectToProvider() {
        $url = url('/api/auth/callback');

        return Socialite::driver('google')
            ->with(["redirect_uri"  => $url])
            ->stateless()->redirect();
    }

    public function handleProviderCallback(Request $request) {
        
        
        $user = Socialite::driver('google')->stateless()->user();
        // try {
        //     echo "ree"; die;
        // }catch (\Exception $e) {
        //     var_dump($e->getMessage()); die;

        //     return redirect('api/auth/login');
        // }
        // // // only allow people with @company.com to login
        // // if(explode("@", $user->email)[1] !== 'pcr.ac.id'){
        // //     return redirect()->to('/');
        // // }

        $existingUser = User::where('email', $user->email)->first();

        if($existingUser) {
            $existingUser = $existingUser->toArray();

            auth()->attempt($existingUser);
            Help::setCookie('ssid', Hash::make($existingUser['name']));
        
        }else {
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->api_token       = hash('sha256', Str::random(60));
            $newUser->avatar_original = $user->avatar_original;
            $newUser->email_verified_at = Carbon::now();
            $newUser->password = null;
            $newUser->save();

            $newUser = $newUser->toArray();

            auth()->attempt($newUser);
        }

        return redirect()->to('/api/kelas');
    }
}
