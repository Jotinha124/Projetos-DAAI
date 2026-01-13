<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $email = $request['email'];
        $palavra_passe = $request['password'];

        $ModeloUser = array(
            'email' => $email,
            'password' => $palavra_passe
        );

        $User = DB::table('users')->where('email', $email)->first();

        if (!$User) {
            session()->flash('mensagem_erro', 'Email or password inválidos!');

            return view('auth.login');
        }
        if (Auth::attempt($ModeloUser)) {
            Session::put('s_userId', $User->id);

            Session::put('s_nome', $User->nome);

            Session::put('s_admin', $User->admin);

            return redirect('dashboard');
        }else{
            session()->flash('mensagem_erro', 'Email or password inválidos!');

            return view('auth.login');
        }
    }
}
