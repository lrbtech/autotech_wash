<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\city;
use App\shop_time;
use App\settings;
use App\app_settings;
use App\service;
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
        $service = service::where('parent_id',0)->where('status',0)->get();
        $profile = User::find(Auth::user()->user_id);
        return view('agent.profile',compact('profile','service'));
    }

    public function updateprofile(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.Auth::user()->user_id,
            'mobile'=>'required|digits:9|unique:users,mobile,'.Auth::user()->user_id,
            'trade_license' => 'mimes:jpeg,jpg,png|max:1000', // max 1000kb
            'passport_copy' => 'mimes:jpeg,jpg,png|max:1000', // max 1000kb
            'emirated_id_copy' => 'mimes:jpeg,jpg,png|max:1000', // max 1000kb
            'cover_image' => 'mimes:jpeg,jpg,png|max:1000', // max 1000kb
            'profile_image' => 'mimes:jpeg,jpg,png|max:1000', // max 1000kb
          ],[
            'trade_license.mimes' => 'Only jpeg, png and jpg images are allowed',
            'trade_license.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'passport_copy.mimes' => 'Only jpeg, png and jpg images are allowed',
            'passport_copy.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'emirated_id_copy.mimes' => 'Only jpeg, png and jpg images are allowed',
            'emirated_id_copy.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'cover_image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'cover_image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'profile_image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'profile_image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
        ]);

        $service_ids1;
        foreach($request->service_ids as $row){
            $service_ids1[]=$row;
        }
        $service_ids = collect($service_ids1)->implode(',');
        
        $profile = User::find(Auth::user()->user_id);
        $profile->name = $request->name;
        $profile->service_ids = $service_ids;
        $profile->other_service = $request->other_service;
        $profile->busisness_name = $request->busisness_name;
        $profile->email = $request->email;
        $profile->mobile = $request->mobile;
        $profile->about_us_english = $request->about_us_english;
        $profile->about_us_arabic = $request->about_us_arabic;

        if($request->file('trade_license')!=""){
            $old_image = "upload_files/".$profile->trade_license;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            $fileName = null;
            $image = $request->file('trade_license');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $profile->trade_license = $fileName;
        }

        if($request->file('passport_copy')!=""){
            $old_image = "upload_files/".$profile->passport_copy;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            $fileName = null;
            $image = $request->file('passport_copy');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $profile->passport_copy = $fileName;
        }

        if($request->file('emirated_id_copy')!=""){
            $old_image = "upload_files/".$profile->emirated_id_copy;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            $fileName = null;
            $image = $request->file('emirated_id_copy');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $profile->emirated_id_copy = $fileName;
        }

        if($request->file('cover_image')!=""){
            $old_image = "upload_files/".$profile->cover_image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            $fileName = null;
            $image = $request->file('cover_image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $profile->cover_image = $fileName;
        }

        if($request->file('profile_image')!=""){
            $old_image = "upload_files/".$profile->profile_image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            $fileName = null;
            $image = $request->file('profile_image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $profile->profile_image = $fileName;
        }

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
