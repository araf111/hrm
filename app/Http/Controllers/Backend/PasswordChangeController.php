<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;
use Auth;

class PasswordChangeController extends Controller
{
    //
    public function changePassword()
    {
    	return view('backend.change_password.change-password');
    } 

    public function storePassword(Request $request)
    {

		/* $old_record = User::where('email',authInfo()->email)
		->where('password',bcrypt($request->password))
		->first();
		if(!empty($old_record)){
			dd($old_record);
		} */

		$rules = [
            'new_password' => 'required|min:8|regex:/^(?=\S*[a-z])(?=\S*[\d])\S*$/',
    		'old_password' => 'required',
    		'confirm_password' => 'required|same:new_password',
        ];
        $message = [
            'old_password.required'   => \Lang::get('This field is required.'),
            'new_password.required'   => \Lang::get('This field is required.'),
            'new_password.min'   => \Lang::get('Password should be minimum 8 character.'),
            'new_password.regex'   => \Lang::get('Password should be (A-Z)(0-9) and special character.'),
            'confirm_password.required'   => \Lang::get('This field is required.'),
            'confirm_password.same'   => \Lang::get('The confirm password dose not match'),
        ];

		$request->validate($rules, $message);

    	// $request->validate([
    	// 	'new_password' => 'required|min:8|regex:/^(?=\S*[a-z])(?=\S*[\d])\S*$/',
    	// 	'confirm_password' => 'required|same:new_password',
    	// ]);
    	
    	$auth_id = authInfo()->id;
    	// dd($auth_id);
    	if($request->new_password == $request->confirm_password)
    	{
    		$previous_password = authInfo()->password;

    		if(Hash::check($request->old_password,$previous_password))
    		{	
    			$user = User::find($auth_id);
    			$password = Hash::make($request->new_password);
    			// dd($password);
    			$user->password = $password;
    			$user->update();
    			session()->flash('success', 'Password Change Successfully!');
				Auth::logout();
				Session::flush();
				return redirect()->route('login');

    		}
    		else
    		{
    			session()->flash('msg', 'Password does not match with previous password');
    			return redirect()->back();
    		}

    	}

    	// return view('backend.change_password.change-password');
    }

}
