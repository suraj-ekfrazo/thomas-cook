<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\createIncidentSuccess;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:agent')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:tcuser')->except('logout');
    }

    public function username()
    {
     return 'name';
     
     }

    public function home()
    {
        return redirect('/agent/login');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function showEmployeeLoginForm()
    {

        return view('agent.auth.login', ['url' => 'agent']);
    }

    public function employeeLogin(Request $request)
    {
        $this->validate($request, [
            // 'email'   => 'required|email',
            'user_name' =>  'required|exists:agents',
            'password' => 'required|min:6'
        ]);
        Log::info($request);

       $agent = (Auth::guard('agent')->attempt(
            ['user_name' => $request->user_name, 'password' => $request->password ,  'status' => 1],
             $request->get('remember') 
       ));
  
	if($agent){
            return redirect()->intended('/agent/dashboard');
        }
        else{
            return redirect()->back()->with('warning', 'Invalid username or password.');
        }        
    }

    public function adminLogin(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if ($user && $user->hasRole(['TC User'])) {

            return redirect()->back()->with('warning', 'Only Admin can login here.');
        }

        $admin =   Auth::guard('admin')->attempt(
            ['email' => $request->email, 'password' => $request->password, 'status' => 1],
            $request->get('remember')
        );
        
	if($admin){
            return redirect()->intended('/dashboard');
        }
        else{
            return redirect()->back()->with('warning', 'Invalid email or password.')->onlyInput('email');
        }
    }

    //Tc User Login
    public function showTcUserLoginForm()
    {
        return view('tcuser.auth.login', ['url' => 'tcuser']);
    }

    public function tcUserLogin(Request $request)
    {
        $this->validate($request, [
            // 'email'   => 'required|email',
            'name' =>  'required|exists:users',
            'password' => 'required|min:6'
        ]);
        $user = User::whereName($request->name)->first();

        if ($user && $user->hasRole(['TC User'])) {
            $auth = Auth::guard('tcuser')->attempt(
                ['name' => $request->name, 'password' => $request->password, 'status' => 1],
                $request->get('remember')
            );

            if($auth){
                return redirect()->intended('/tcuser/dashboard');
            }
            else{
                return redirect()->back()->with('warning', 'Invalid username or password.');
            }

        } else {
            return redirect()->back()->with('warning', 'Only TC User can login here.');
        }
        return back()->withInput($request->only('email', 'remember'));

    }
}

