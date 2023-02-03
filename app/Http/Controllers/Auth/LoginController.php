<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('custom.guest_token')->except('logout');
    }

    public function login(Request $request)
    {        
        $response = Http::post(env('APP_API_URL').'/api/v1/users/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        $responseBody = json_decode($response->body());

        if($response->successful()){
            \Cache::put('token', $responseBody->token, now()->addHours(24));
            return redirect(route('home'));
        }

        if($response->failed()){
            return $this->returnFailedResponse($response->status(), $responseBody);
        }
    }

    public function logout(Request $request)
    {
        \Cache::forget('token');
        return redirect(route('login'));
    }
}
