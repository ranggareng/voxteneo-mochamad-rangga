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
        try{
            $response = Http::post(env('APP_API_URL').'/api/v1/users/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            $responseBody = json_decode($response->body());
            \Log::debug($response->body());

            if($response->successful()){
                \Cache::put('token', $responseBody->token, now()->addHours(24));
                return redirect(route('home'));
            }

            if($response->failed()){
                switch($response->status()){
                    case 401:
                        return redirect()->back()->withInput()->withError(__('auth.'.$responseBody->error));
                    case 403:
                        return redirect()->back()->withInput()->withError('Forbidden');
                    case 404:
                        return redirect()->back()->withInput()->withError('Service Not Found');
                    case 422:
                        return redirect()->back()->withInput()->withErrors($responseBody->errors);
                }
            }
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->withInput()->withError(__('auth.invalid_credentials'));
        }
        
    }
}
