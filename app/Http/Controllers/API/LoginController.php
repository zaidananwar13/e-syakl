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
            $api_token = $existingUser['api_token'];
            $name = $existingUser['name'];
            $email = $existingUser['email'];
            $img = $existingUser['avatar_original'];

            auth()->attempt($existingUser);
            Help::setCookie('ssid', Hash::make($existingUser['name']));
        
        }else {
            $api_token = hash('sha256', Str::random(60));
            $name = $user->name;
            $email = $user->email;
            $img = $user->avatar_original;

            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->api_token       = $api_token;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->email_verified_at = Carbon::now();
            $newUser->password = null;
            $newUser->save();

            $newUser = $newUser->toArray();

            auth()->attempt($newUser);
        }

        $body = "<body>
            <form action=\"http://localhost:5000/\" method=\"post\">
                <input type=\"hidden\" name=\"api_token\" value=\"$api_token\" />
                <input type=\"hidden\" name=\"name\" value=\"$name\" />
                <input type=\"hidden\" name=\"email\" value=\"$email\" />
                <input type=\"hidden\" name=\"img\" value=\"$img\" />
            </form>
        </body>";

        echo $body;

        $script = "
            <script>
                var form = document.querySelector('form');
                form.submit();
            </script>
        ";
        echo $script;

        die;
        return redirect()->to('/api/kelas');
    }
}
