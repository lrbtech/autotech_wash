<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\admin;
use App\customer;
use App\brand;
use App\vehicle_type;
use App\vehicles;
use App\manage_address;
use App\city;
use App\service;
use App\booking;
use App\booking_service;
use App\booking_package;
use App\booking_product;
use App\shop_service;
use App\shop_package;
use App\shop_product;
use App\shop_time;
use App\service_price;
use App\app_settings;
use App\colour;
use App\coupon;
use App\push_notification;
use Hash;
use Auth;
use DB;
use Validator;
use Mail;
use Carbon\Carbon;

class AgentController extends Controller
{
    private function send_sms($phone,$msg)
    {
        $requestParams = array(
          'api_key' => 'C2003249604f3c09173d94.20000197',
          'type' => 'text',
          'contacts' => '+971'.$phone,
          'senderid' => 'WellWellExp',
          'msg' => $msg
        );
        
        //merge API url and parameters
        $apiUrl = 'https://www.elitbuzz-me.com/sms/smsapi?';
        foreach($requestParams as $key => $val){
            $apiUrl .= $key.'='.urlencode($val).'&';
        }
        $apiUrl = rtrim($apiUrl, "&");
      
        //API call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      
        curl_exec($ch);
        curl_close($ch);
    }

    public function agentLogin(Request $request){
        $exist = User::where('mobile',$request->mobile)->get();
        if(count($exist)>0){
            if($exist[0]->status == 0){
                if(Hash::check($request->password,$exist[0]->password)){
                    // $agent = User::find($exist[0]->id);
                    // $agent->firebase_key = $request->firebase_key;
                    // $agent->save();
                
                $agent_type='';
                if($exist[0]->id == $exist[0]->user_id){
                    $agent_type='admin';
                }
                else{
                    $agent_type='staff';
                }        
                return response()->json(['message' => 'Login Successfully',
                '_id'=>$exist[0]->id,
                'shop_id'=>$exist[0]->user_id,
                'agent_type'=>$agent_type,
                ], 200);
                }else{
                    return response()->json(['message' => 'Records Does not Match','status'=>403], 403);
                }
            }else{
                return response()->json(['message' => 'Verify Your Account','status'=>401,'customer_id'=>$exist[0]->id], 401);
            }
        }else{
            return response()->json(['message' => 'Mobile Number Not Registered','status'=>404], 404);
        }
    }

    public function getlistservice(){
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        $data =array();
        $datas =array();
        foreach ($service as $key => $value) {
            $data = array(
                'service_id' => $value->id,
                'service_image' => '',
                'service_name_english' => $value->service_name_english,
                'service_name_arabic' => $value->service_name_arabic,
            );
            if($value->image !=null){
                $data['service_image'] = 'upload_service/'.$value->image;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-list-service','data'=>$datas]);
    }

    public function getservice($id){
        $service = shop_service::where('shop_id',$id)->where('status',0)->get();
        $data =array();
        $datas =array();
        foreach ($service as $key => $value) {
            $service = service::find($value->service_id);
            $data = array(
                'service_id' => $service->id,
                'service_image' => '',
                'service_name_english' => $service->service_name_english,
                'service_name_arabic' => $service->service_name_arabic,
                'price' => (double)$value->price,
            );
            if($service->image !=null){
                $data['service_image'] = 'upload_service/'.$service->image;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-service','data'=>$datas]);
    }

    public function saveservice(Request $request){
        try{
            $service = service::where('service_name_english',$request->service_id)->first();
            $shop_service = shop_service::where('service_id',$service->id)->where('shop_id',$request->shop_id)->get();
            if(count($shop_service)>0){
                return response()->json(['message' => 'This Service Has been Already Registered','status'=>403], 403);
            }
            
            $service = new shop_service;
            $service->shop_id = $request->shop_id;
            $service->service_id = $service->id;
            $service->price = $request->price;
            $service->save();

            return response()->json(
            ['message' => 'Save Successfully',
            'service_id'=>$service->id,
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),'status'=>400], 400);
        } 
    }

    public function getproduct($id){
        $product = shop_product::where('shop_id',$id)->where('status',0)->get();
        $data =array();
        $datas =array();
        foreach ($product as $key => $value) {
            $data = array(
                'product_id' => $value->id,
                'product_image' => '',
                'product_name_english' => $value->product_name_english,
                'product_name_arabic' => '',
                'price' => (double)$value->price,
            );
            if($value->image !=null){
                $data['product_image'] = 'upload_service/'.$value->image;
            }
            if($value->product_name_arabic != null){
                $data['product_name_arabic'] = $value->product_name_arabic;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-product','data'=>$datas]);
    }

    public function saveproduct(Request $request){
        try{            
            $shop_product = shop_product::where('product_name_english',$request->product_name_english)->where('shop_id',$request->shop_id)->get();
            if(count($shop_product)>0){
                return response()->json(['message' => 'This Product Has been Already Registered','status'=>403], 403);
            }

            $product = new shop_product;
            $product->shop_id = $request->shop_id;
            $product->price = $request->price;
            $product->product_name_english = $request->product_name_english;
            $product->product_name_arabic = $request->product_name_arabic;
            if(isset($request->image)){
                if($request->file('image')!=""){
                    $image = $request->image;
                    $image_name = $request->image_name;
                    $filename1='';
                    foreach(explode('.', $image_name) as $info){
                        $filename1 = $info;
                    }
                    $fileName = rand() . '.' . $filename1;
                    $realImage = base64_decode($image);
                    file_put_contents(public_path().'/upload_service/'.$fileName, $realImage);    
                    $product->image =  $fileName;
                }
            }
            $product->save();

            return response()->json(
            ['message' => 'Save Successfully',
            'product_id'=>$product->id,
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),'status'=>400], 400);
        } 
    }

    public function getpackage($id){
        $package = shop_package::where('shop_id',$id)->where('status',0)->get();
        $data =array();
        $datas =array();
        foreach ($package as $key => $value) {
            $data = array(
                'package_id' => $value->id,
                'package_image' => '',
                'package_name_english' => $value->package_name_english,
                'package_name_arabic' => '',
                'price' => (double)$value->price,
            );
            if($value->image !=null){
                $data['package_image'] = 'upload_service/'.$value->image;
            }
            if($value->package_name_arabic != null){
                $data['package_name_arabic'] = $value->package_name_arabic;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-package','data'=>$datas]);
    }

    public function getpackageservices($id){
        $package = shop_package::find($id);
        $data =array();
        $datas =array();
        foreach(explode(',',$package->service_ids) as $service_id){
            $service = service::find($service_id);
            $data = array(
                'service_id' => $service->id,
                'service_name' => $service->service_name_english,
                'service_image' => '',
            );
            if($service->image !=null){
                $data['service_image'] = 'upload_service/'.$service->image;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-package-services','data'=>$datas]);
    }

    public function savepackage(Request $request){
        try{            
            $shop_package = shop_package::where('package_name_english',$request->package_name_english)->where('shop_id',$request->shop_id)->get();
            if(count($shop_package)>0){
                return response()->json(['message' => 'This Package Name Has been Already Registered','status'=>403], 403);
            }

            $package = new shop_package;
            $package->shop_id = $request->shop_id;
            $package->service_ids = $request->service_ids;
            $package->price = $request->price;
            $package->package_name_english = $request->package_name_english;
            $package->package_name_arabic = $request->package_name_arabic;
            if(isset($request->image)){
                if($request->file('image')!=""){
                    $image = $request->image;
                    $image_name = $request->image_name;
                    $filename1='';
                    foreach(explode('.', $image_name) as $info){
                        $filename1 = $info;
                    }
                    $fileName = rand() . '.' . $filename1;
                    $realImage = base64_decode($image);
                    file_put_contents(public_path().'/upload_service/'.$fileName, $realImage);    
                    $package->image =  $fileName;
                }
            }
            $package->save();

            return response()->json(
            ['message' => 'Save Successfully',
            'package_id'=>$package->id,
            ], 200);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),'status'=>400], 400);
        } 
    }


    public function getbooking($id){
        $booking = booking::where('shop_id',$id)->orderBy('id','DESC')->get();
        $data =array();
        $datas =array();
        foreach ($booking as $key => $value) {
            $shop = User::find($value->shop_id);
            $customer = customer::find($value->customer_id);
            $vehicle = vehicles::find($value->vehicle_id);
            $shop = User::find($value->shop_id);
            $data = array(
                'booking_id' => $value->id,
                'name' => $customer->first_name .' '. $customer->last_name,
                'image' => '',
                'booking_type' => '',
                'booking_for' => $value->booking_for,
                'booking_date' => $value->booking_date,
                'booking_time' => $value->booking_time,
                'vehicle'=> $vehicle->vehicle_name,
            );
            if($shop->other_service == 0){
                $data['booking_type'] = 'Home Services';
            }
            else{
                $data['booking_type'] = 'Visitus';
            }
            if($customer->image !=null){
                $data['image'] = 'profile_image/'.$customer->image;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-booking','data'=>$datas]); 
    }

    public function getbookingdetails($id){
        $booking = booking::where('id',$id)->get();
        $data =array();
        $datas =array();
        foreach ($booking as $key => $value) {
            $shop = User::find($value->shop_id);
            $customer = customer::find($value->customer_id);
            $vehicle = vehicles::find($value->vehicle_id);
            $data = array(
                'booking_id' => $value->id,
                'customer_name' => $customer->first_name .' '. $customer->last_name,
                'customer_mobile' => $customer->mobile,
                'booking_date' => $value->booking_date,
                'booking_time' => $value->booking_time,
                'booking_status' => (int)$value->booking_status,
                'payment_type' => (int)$value->payment_type,
                'payment_status' => (int)$value->payment_status,
                'otp' => $value->otp,
                'subtotal' => $value->subtotal,
                'total' => $value->total,
                'coupon_code' => '',
                'coupon_value' => 0.0,
                'vehicle_name'=> $vehicle->vehicle_name,
                'vehicle_no'=> $vehicle->registration_city .' '. $vehicle->registration_code .' '. $vehicle->registration_number,
                'booking_type' => '',
                'latitude' => $value->latitude,
                'longitude' => $value->longitude,
                'address' => $value->address,
            );
            if($shop->other_service == 0){
                $data['booking_type'] = 'Home Services';
            }
            else{
                $data['booking_type'] = 'Visitus';
            }
            if(empty($shop->busisness_name)){
                $data['shop_name'] = $shop->name;
            }
            if($value->coupon_code !=null){
                $data['coupon_code'] = $value->coupon_code;
            }
            if($value->coupon_value !=null){
                $data['coupon_value'] = $value->coupon_value;
            }
            $datas[] = $data;
        }   
        return response()->json(['message'=>'get-booking-details','data'=>$datas]); 
    }

    public function getbookingservice($id){
        $booking = booking_service::where('booking_id',$id)->get();
        $data =array();
        if(count($booking) >0){
            foreach ($booking as $key => $value) {
                $service = service::find($value->service_id);
                $data = array(
                    'booking_id' => $value->id,
                    'service_image' => '',
                    'service_name_english' => $service->service_name_english,
                    'service_name_arabic' => $service->service_name_arabic,
                    'price' => $value->price,
                );
                if($service->image !=null){
                    $data['service_image'] = 'upload_service/'.$service->image;
                }
                $datas[] = $data;
            }
        }else{
            $datas=array();
        }
        return response()->json(['message'=>'get-booking-service','data'=>$datas]); 
    }

    public function getbookingpackage($id){
        $package = booking_package::where('booking_id',$id)->get();
        $data =array();
        if(count($package) >0){
            foreach ($package as $key => $value) {
                $pack = shop_package::find($value->package_id);
                $data = array(
                    'package_id' => $value->package_id,
                    'package_name' => $value->package_name,
                    'package_price' => $value->price,
                    'package_image' => '',
                );
                if($pack->image !=null){
                    $data['package_image'] = 'upload_service/'.$pack->image;
                }
                $datas[] = $data;
            }   
        }else{
            $datas=array();
        }
        return response()->json(['message'=>'get-booking-package','data'=>$datas]);  
    }

    public function getbookingproduct($id){
        $product = booking_product::where('booking_id',$id)->get();
        $data =array();
        if(count($product) >0){
            foreach ($product as $key => $value) {
                $pack = shop_product::find($value->product_id);
                $data = array(
                    'product_id' => $value->product_id,
                    'product_name' => $value->product_name,
                    'product_price' => $value->price,
                    'product_image' => '',
                );
                if($pack->image !=null){
                    $data['product_image'] = 'upload_service/'.$pack->image;
                }
                $datas[] = $data;
            }   
        }else{
            $datas=array();
        }
        return response()->json(['message'=>'get-booking-product','data'=>$datas]);  
    }


    public function getnotification($id){
        $data = push_notification::where('status',1)->where('send_to',1)->get();
        $data1 = push_notification::where('status',1)->where('send_to',3)->get();
        foreach ($data as $key => $value) {
            $data = array(
                'title' => $value->title,
                'description' => '',
            );
            if($value->description != null){
                $data['description'] = $value->description;
            }
            $datas[] = $data;
        }   
        
        foreach ($data1 as $key => $value) {
            $arraydata=array();
            foreach(explode(',',$value->shop_ids) as $shop1){
                $arraydata[]=$shop1;
            }
            if(in_array($id , $arraydata))
            {
                $data = array(
                    'title' => $value->title,
                    'description' => '',
                );
                if($value->description != null){
                    $data['description'] = $value->description;
                }
                $datas[] = $data;
            }
        }   
        return response()->json($datas); 
    }


}
