<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Auth;
use Session;
use App\Model\V2Profile;
use Illuminate\Support\Facades\Http;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // use AuthenticatesUsers;
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'             => 'required|string',
            'password'          => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /* if(authInfo()->usertype=='mp'){
                $profileInfo = V2Profile::where('user_id',authInfo()->id)->first();
                authInfo()->profileData = (!empty($profileInfo) && $profileInfo->id>0)? $profileInfo:[];
            } */
            return response()->json(['status' => 'success', 'message' => Lang::get('Login Successfull')]);
        } else {
            return response()->json(['status' => 'error', 'message' => Lang::get('Sorry !! your email or password wrong')]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        if ($_POST) {
            session()->flash('success', 'logout succseefully..!');
        } else {
            session()->flash('error', 'You are not allow right now or your course end time expired !');
        }
        return redirect()->route('login');
    }
}
