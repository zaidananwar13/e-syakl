<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(trim($request->input('api_token')))){

            $is_exists = User::where('api_token' , $request->input('api_token'))->first();

            if($is_exists != null){
                return $next($request);
            }
        }

        return response()->json('Invalid Token', 401);
    }
}
