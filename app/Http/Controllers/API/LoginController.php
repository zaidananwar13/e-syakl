<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function redirectToProvider() {
        return Socialite::driver('google')->stateless()->redirect();
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

        $existingUser = $existingUser->toArray();

        if($existingUser) {
            auth()->attempt($existingUser);
            Help::setCookie('ssid', Hash::make($existingUser['name']));
        
        }else {
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();

            auth()->attempt($newUser);
        }

        return redirect()->to('/api/kelas');
    }
}
