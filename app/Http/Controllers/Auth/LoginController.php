<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string', 
            'password' => 'required|string',
        ]);

    
        $login = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (auth()->attempt($login)) {
            if(auth()->user()->status == 'aktif'){
                return redirect()->route('home');
            }
            $this->guard()->logout();
            Alert::warning('Akun Anda di Nonaktifkan', 'Hubungi Guru BK');
            return redirect()->route('login');
        }
        //JIKA SALAH, MAKA KEMBALI KE LOGIN DAN TAMPILKAN NOTIFIKASI 
        Alert::warning('username/Password salah!');
        return redirect()->route('login');
    }
}
