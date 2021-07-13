<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\city;
use App\shop_time;
use App\settings;
use App\app_settings;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;
use Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function profile()
    {
        $profile = User::find(Auth::user()->user_id);
        return view('agent.profile',compact('profile'));
    }

    public function updateprofile(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.Auth::user()->user_id,
            'mobile'=>'required|digits:9|unique:users,mobile,'.Auth::user()->user_id,
            //'image' => 'required|mimes:jpeg,jpg,png|max:1000', // max 1000kb
          ],[
            // 'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            // 'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            // 'image.required' => 'Profile Image Field is Required',
        ]);
        
        $profile = User::find(Auth::user()->user_id);
        $profile->name = $request->name;
        $profile->busisness_name = $request->busisness_name;
        $profile->email = $request->email;
        $profile->mobile = $request->mobile;
        $profile->about_us_english = $request->about_us_english;
        $profile->about_us_arabic = $request->about_us_arabic;
        $profile->save();

        return response()->json('successfully update'); 
    }

    public function changepassword()
    {
        $user = User::find(Auth::user()->id);
        return view('agent.changepassword',compact('user'));
    }

    public function updatepassword(Request $request){
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        
        $hashedPassword = Auth::user()->password;
 
        if (\Hash::check($request->oldpassword , $hashedPassword )) {
 
            if (!\Hash::check($request->password , $hashedPassword)) {
 
                $user = User::find($request->id);
                $user->password = Hash::make($request->password);
                $user->save();
 
                return response()->json(['message' => 'Password Updated Successfully!' , 'status' => 1], 200);
            }
 
            else{
                return response()->json(['message' => 'new password can not be the old password!' , 'status' => 0]);
            }
 
           }
 
        else{
            return response()->json(['message' => 'old password doesnt matched!' , 'status' => 0]);
        }
    }


    public function staff(){
        $staff = User::where('role_id', '!=' ,'admin')->where('user_id',Auth::user()->user_id)->get();
        return view('agent.staff',compact('staff'));
    }

    public function savestaff(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users',
            'mobile'=>'required|unique:users|digits:9',
            'password'=>'required',
            //'image' => 'required|mimes:jpeg,jpg,png|max:1000', // max 1000kb
          ],[
            // 'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            // 'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            // 'image.required' => 'Profile Image Field is Required',
        ]);
        
        $staff = new User;
        $staff->user_id = Auth::user()->user_id;
        $staff->role_id = 0;
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->mobile = $request->mobile;
        $staff->password = Hash::make($request->password);
        $staff->save();

        return response()->json('successfully save'); 
    }

    public function updatestaff(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$request->id,
            'mobile'=>'required|digits:9|unique:users,mobile,'.$request->id,
            //'image' => 'required|mimes:jpeg,jpg,png|max:1000', // max 1000kb
          ],[
            // 'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            // 'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            // 'image.required' => 'Profile Image Field is Required',
        ]);
        
        $staff = User::find($request->id);
        $staff->role_id = 0;
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->mobile = $request->mobile;
        if($request->password != ''){
        $staff->password = Hash::make($request->password);
        }
        $staff->save();

        return response()->json('successfully update'); 
    }

    public function editstaff($id){
        $staff = User::find($id);
        return response()->json($staff); 
    }
    
    public function deletestaff($id,$status){
        $staff = User::find($id);
        $staff->status = $status;
        $staff->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


}
