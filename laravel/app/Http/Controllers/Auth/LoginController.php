<?php

namespace App\Http\Controllers\Auth;

use Session;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Model\UserLog;
use App\Model\Preference; 

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
    protected $redirectTo = '/editor';
    protected $redirectPath = '/editor';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Session::put($request->branch_id);
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        $preference = Preference::Where('id', 1)->first();    
        
        return view('auth.login', compact('preference'));
    }

     public function login(Request $request)
    {

        Session::put('branch_id', $request->branch_id);

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $log = new UserLog;
            $arrToJson = ['action' => 'login', 'user_id' => Auth::id()];
            $log->user_id = Auth::id();
            $log->scope = 'AUTHENTICATION';
            $log->data = json_encode($arrToJson);

            $log->save();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        //Session::put($request->branch_id);
        session(['branch_id' => $request->branch_id]);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    { 
        $log = new UserLog;
        $arrToJson = ['action' => 'logout', 'user_id' => Auth::id()];
        $log->user_id = Auth::id();
        $log->scope = 'AUTHENTICATION';
        $log->data = json_encode($arrToJson);

        $log->save();


        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($this->redirectAfterLogout);
    }
}
