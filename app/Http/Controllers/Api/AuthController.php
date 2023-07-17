<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ProfileTrait;
use App\Model\V2Profile;
use Illuminate\Support\Facades\DB;
use App\Model\LoginActivity;

class AuthController extends Controller
{
    use ProfileTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
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
            $profileInfo = V2Profile::where('user_id', $this->respondWithToken($token)->original['user']->id)
            ->where('v2_profiles.status', 1)
            ->leftJoin('parliaments', 'v2_profiles.parliamentNumber', '=', 'parliaments.id')
            // ->leftJoin('ministries', 'profiles.ministry_id', '=', 'ministries.id')
            ->leftJoin('designations', 'v2_profiles.designation_id', '=', 'designations.id')
            ->leftJoin('political_parties', 'v2_profiles.political_parties_id', '=', 'political_parties.id')
            ->leftJoin('constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number')
            ->leftJoin('districts', 'constituencies.district_id', '=', 'districts.id')
            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
            ->select('v2_profiles.*', 'parliaments.parliament_number', 'designations.name_bn as designation_name', 'political_parties.name_bn as political_party_name', 'constituencies.bn_name as voter_area','constituencies.name as voter_area_en', 'constituencies.number as bangladesh_number','divisions.bn_name as division_name_bn','divisions.name as division_name_en','districts.bn_name as district_name_bn','districts.name as district_name_bn')
            ->first();
            
            //V2Profile::where('user_id',$this->respondWithToken($token)->original['user']->id)->first(); //$this->getProfile($this->respondWithToken($token)->original['user']->id);
            $response['api_info']    = $this->respondWithToken($token);
            $response['api_info']->original['profileData'] = (!empty($profileInfo) && $profileInfo->id>0)? $profileInfo:[];
            $response['status'] = 'success';
            $response['message'] = 'Successfully Login';

            DB::table('login_activities')->insert(array(
                'user_id'=>$this->respondWithToken($token)->original['user']->id,
                'ip_address'=>\Request::ip(),
                'user_agent'=>$_SERVER['HTTP_USER_AGENT'],
                'login_time'=>date('Y-m-d H:i:s'),
                'logout_time'=>''
            ));

            if($response['api_info']->original['user']->usertype!=='mp'){
                $data['status'] = 'error';
                $data['message'] = 'You are not authorized';
                return response()->json($data);
            }
            else{
                return response()->json($response);
            }
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Email or Password not Correct';
            return response()->json($response);
        }
        
    }

    public function logout()
    {
        $existing_login = LoginActivity::where('user_id', auth('api')->user()->id)->orderBy('id','desc')->first();
        if (!empty($existing_login)) {
            DB::table('login_activities')->where('id', $existing_login->id)->update(
                array('logout_time' => date('Y-m-d H:i:s'))
            );
        }

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
            'expires_in' => (auth('api')->factory()->getTTL() * 60),
            'user' => auth('api')->user()
        ]);
    }
    
    public function guard()
    {
        return Auth::guard('api');
    }
}