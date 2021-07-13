<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\agent_password;
use App\User;
use App\customer;
use App\booking;
use App\booking_service;
use App\booking_package;
use App\booking_product;
use App\city;
use App\settings;
use App\shop_time;
use App\service;
use Hash;
use DB;
use Mail;
use PDF;

class HomeController extends Controller
{
    public function bookingprint($id){
        $booking = booking::find($id);
        $booking_service = booking_service::where('booking_id',$id)->get();
        $booking_package = booking_package::where('booking_id',$id)->get();
        $booking_product = booking_product::where('booking_id',$id)->get();
        $shop = User::find($booking->shop_id);
        $customer = customer::find($booking->customer_id);
        //return view('print.booking_print',compact('booking_service','booking','booking_product','booking_package','customer','shop'));
        $pdf = PDF::loadView('print.booking_print',compact('booking_service','booking','booking_product','booking_package','customer','shop'));
        $pdf->setPaper('A4');
        return $pdf->stream('report.pdf');
        // $html = view('print.booking_print',compact('booking_service','booking','booking_product','booking_package','customer','shop'))->render();

        // return response()->json(['html'=>$html],200); 
    }

    public function home(){
        $settings = settings::first();
        return view('page.home',compact('settings'));
	}
    public function about(){
        $settings = settings::first();
        return view('page.about',compact('settings'));
	}
    public function faq(){
        $settings = settings::first();
        return view('page.faq',compact('settings'));
	}
    public function contact(){
        $settings = settings::first();
        return view('page.contact',compact('settings'));
	}
    public function service(){
        $settings = settings::first();
        return view('page.service',compact('settings'));
	}
    public function carwashservices(){
        $settings = settings::first();
        return view('page.carwashservices',compact('settings'));
	}
    public function garageservices(){
        $settings = settings::first();
        return view('page.garageservices',compact('settings'));
	}
    public function pickupservices(){
        $settings = settings::first();
        return view('page.pickupservices',compact('settings'));
	}


    public function AgentRegister(){
		$service = service::where('parent_id',0)->where('status',0)->get();
        $city = city::where('parent_id',0)->where('status',0)->get();
        $area = city::where('parent_id','!=',0)->where('status',0)->get();
        $terms = settings::first();
        return view('page.register',compact('city','area','terms','service'));
	}
    public function saveAgentRegister(Request $request){
        $service_ids1;
        foreach($request->service_ids as $row){
            $service_ids1[]=$row;
        }
        $service_ids = collect($service_ids1)->implode(',');

        $agent = new User;
        $agent->date = date('Y-m-d');
        $agent->service_ids = $service_ids;
        $agent->other_service = $request->other_service;
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->mobile = $request->mobile;
        // $agent->password = Hash::make($request->password);
        $agent->busisness_name = $request->busisness_name;
        $agent->busisness_id = $request->busisness_id;
        $agent->emirates_id = $request->emirates_id;
        $agent->trade_license_no = $request->trade_license_no;
        $agent->vat_certificate_no = $request->vat_certificate_no;
        $agent->passport_number = $request->passport_number;
        //$agent->member_license = $request->member_license;
        $agent->city = $request->city;
        $agent->latitude = $request->latitude;
        $agent->longitude = $request->longitude;
        $agent->address = $request->address;
        $agent->role_id = 'admin';

        if($request->file('trade_license')!=""){
            $fileName = null;
            $image = $request->file('trade_license');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $agent->trade_license = $fileName;
        }

        if($request->file('passport_copy')!=""){
            $fileName = null;
            $image = $request->file('passport_copy');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $agent->passport_copy = $fileName;
        }

        if($request->file('emirated_id_copy')!=""){
            $fileName = null;
            $image = $request->file('emirated_id_copy');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $agent->emirated_id_copy = $fileName;
        }

        if($request->file('cover_image')!=""){
            $fileName = null;
            $image = $request->file('cover_image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $agent->cover_image = $fileName;
        }

        if($request->file('profile_image')!=""){
            $fileName = null;
            $image = $request->file('profile_image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $fileName);
        $agent->profile_image = $fileName;
        }

        $agent->signature_data = $request->imgData;
        $agent->save();

        $agent1=User::find($agent->id);
        $agent1->user_id = $agent->id;
        $agent1->save();

        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        for ($i = 0; $i < 7; $i++) {
            $shop_time = new shop_time;
            $shop_time->agent_id = $agent->id;
            $shop_time->days = $days[$i];
            $shop_time->save();
        }

        $agent_password = new agent_password;
        $agent_password->date = date('Y-m-d');
        $agent_password->end_date = date('Y-m-d', strtotime("+14 days"));
        $agent_password->agent_id = $agent->id;
        $agent_password->busisness_name = $agent->busisness_name;
        $agent_password->name = $agent->name;
        $agent_password->email = $agent->email;
        $agent_password->save();


        $all = $agent_password::find($agent_password->id);
        Mail::send('mail.agent_send_mail',compact('all'),function($message) use($all){
            $message->to($all['email'])->subject('Create your Own Password');
            $message->from('info@lrbinfotech.com','Auto Wash Website');
        });

        
        return response()->json('successfully save'); 
    }

    public function AgentBasicValidate(Request $request){
        $this->validate($request, [
            'email'=> 'required|email|unique:users',
            'mobile'=> 'required|numeric|digits:9|unique:users',
            'service_ids'=>'required',
            'name'=>'required',
            'trade_license_no'=>'required',
            //'vat_certificate_no'=>'required',
            //'emirates_id'=>'required',
            //'passport_number'=>'required',
            'busisness_name'=>'required',
            'cover_image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
            'profile_image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
            'passport_copy' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
            'emirated_id_copy' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
            'trade_license' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'service_ids.required' => 'Atleast one Category is required',
            'name.required' => 'Owner Name Field is required',
            'cover_image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'cover_image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'cover_image.required' => 'Cover Image Field is Required',
            'profile_image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'profile_image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'profile_image.required' => 'Profile Image Field is Required',
            'passport_copy.mimes' => 'Only jpeg, png and jpg images are allowed',
            'passport_copy.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'passport_copy.required' => 'Passport ID Proof  Field is Required',
            'emirated_id_copy.mimes' => 'Only jpeg, png and jpg images are allowed',
            'emirated_id_copy.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'emirated_id_copy.required' => 'Emirated ID Proof Field is Required',
            'trade_license.mimes' => 'Only jpeg, png and jpg images are allowed',
            'trade_license.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'trade_license.required' => 'Trade License Copy Field is Required',
        ]);
        
        return response()->json(true); 
        //return response()->json(['error' => false, 'success' => true]);
    }

    public function AgentContactValidate(Request $request){
        $request->validate([
            'city'=>'required',
            'address'=>'required',
        ]);
        
        return response()->json(true); 
    }

    public function agentCreatePassword($id){
        $agent = agent_password::find($id);
        return view('page.agent_new_password',compact('agent','id'));
    }

    public function agentUpdatePassword(Request $request){
        $request->validate([
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        $agent = User::find($request->agent_id);
        $agent->password = Hash::make($request->password);
        $agent->save();

        $agent_password = agent_password::find($request->id);
        $agent_password->status = 1;
        $agent_password->save();
        
        return response()->json('successfully save'); 
    }


}
