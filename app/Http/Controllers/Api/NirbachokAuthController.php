<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\V2Profile;
use App\SelectedUser;

class NirbachokAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:nirbachok', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            //dd($this->respondWithToken($token));
            $profileInfo = V2Profile::where('user_id', $this->respondWithToken($token)->original['user']->mp_id)
            ->where('v2_profiles.status', 1)
            ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.id')
            // ->leftJoin('ministries', 'profiles.ministry_id', '=', 'ministries.id')
            ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
            ->leftJoin('districts', 'constituencies.district_id', '=', 'districts.id')
            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
            ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number','divisions.bn_name as division_name_bn','divisions.name as division_name_en','districts.bn_name as district_name_bn','districts.name as district_name_bn')
            ->first();
            
            //V2Profile::where('user_id',$this->respondWithToken($token)->original['user']->id)->first(); //$this->getProfile($this->respondWithToken($token)->original['user']->id);
            $response['api_info']    = $this->respondWithToken($token);
            $response['api_info']->original['profileData'] = (!empty($profileInfo) && $profileInfo->id>0)? $profileInfo:[];
            $response['status'] = 'success';
            $response['message'] = 'Successfully Login';
            
            return response()->json($response);
        }

        $response['status'] = 'error';
        $response['message'] = 'Email or Password not Correct';
        return response()->json($response);
        
    }

    public function logout()
    {
        $this->guard()->logout();
        $response['status'] = 'success';
        $response['message'] = 'Successfully logged out';
        return response()->json($response);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth('nirbachok')->factory()->getTTL() * 60),
            'user' => auth('nirbachok')->user()
        ]);
    }
    
    public function guard()
    {
        return Auth::guard('nirbachok');
    }

    public function selectedUserDetails($id)
    {
        $data['profile_info'] = SelectedUser::findOrFail($id);

        $profileInfo = V2Profile::where('user_id', $data['profile_info']->mp_id)
            ->where('v2_profiles.status', 1)
            ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.id')
            // ->leftJoin('ministries', 'profiles.ministry_id', '=', 'ministries.id')
            ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
            ->leftJoin('districts', 'constituencies.district_id', '=', 'districts.id')
            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
            ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area', 'constituencies.number as bangladesh_number','divisions.bn_name as division_name_bn','divisions.name as division_name_en','districts.bn_name as district_name_bn','districts.name as district_name_bn')
            ->first();
            
            $data['mp_profile'] = (!empty($profileInfo) && $profileInfo->id>0)? $profileInfo:[];

        if (isApi()) {
            $response['status'] = 'success';
            $response['message'] = '';
            $response['api_info']    = $data;
            return response()->json($response);
        }
        //return view('backend.app_management.selected_user.form', $data);
    }
}