<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\service;
use App\coupon;
use Auth;
use DB;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $coupon = coupon::where('status',1)->get();
        return view('agent.coupon',compact('coupon'));
    }

    public function addcoupon(){
        $service = service::where('parent_id','!=',0)->where('shop_id',Auth::user()->user_id)->where('status',0)->get();
        $user = customer::all();
        return view('agent.addcoupon',compact('user','service'));
    }

    public function savecoupon(Request $request){
        $request->validate([
            'coupon_code'=>'required|unique:coupons',
            'description'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'discount_type'=>'required',
            'amount'=>'required',
        ]);
        // $service='';
        // if($request->discount_type == '1' || $request->discount_type == '2'){
        //     $serviceDummy;
        //     foreach($request->service_id as $row){
        //         $serviceDummy[]=$row;
        //     }
        //     $service = collect($serviceDummy)->implode(',');
        // }
        $user_id='';
        if($request->user_type == '1'){
            $user1;
            foreach($request->user_id as $row){
                $user1[]=$row;
            }
            $user_id = collect($user1)->implode(',');
        }

        $coupon = new coupon;
        $coupon->shop_id = Auth::user()->user_id;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->description = $request->description;
        $coupon->start_date = date('Y-m-d',strtotime($request->start_date));
        $coupon->end_date = date('Y-m-d',strtotime($request->end_date));
        $coupon->discount_type = $request->discount_type;
        //$coupon->service_id = $service;
        $coupon->amount = $request->amount;
        //$coupon->max_value = $request->max_value;
        $coupon->limit_per_user = $request->limit_per_user;
        $coupon->minimum_order_value = $request->minimum_order_value;
        $coupon->user_type = $request->user_type;
        $coupon->user_id = $user_id;
        $coupon->status = 1;
        $coupon->save();
        return response()->json($coupon); 
    }
   
    public function editcoupon($id){
        $coupon = coupon::find($id);
        return response()->json($coupon); 
    }

    public function viewcoupon($id){ 
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        $user = customer::all();
        return view('agent.addcoupon',compact('id','service','user'));
    }

    public function updatecoupon(Request $request){
        $request->validate([
            'coupon_code'=>'required|unique:coupons,coupon_code,'.$request->id,
            'description'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'discount_type'=>'required',
            'amount'=>'required',
        ]);
        // $service='';
        // if($request->discount_type == '1' || $request->discount_type == '2'){
        //     $serviceDummy;
        //     foreach($request->service_id as $row){
        //         $serviceDummy[]=$row;
        //     }
        //     $service = collect($serviceDummy)->implode(',');
        // }
        $user_id='';
        if($request->user_type == '1'){
            $user1;
            foreach($request->user_id as $row){
                $user1[]=$row;
            }
            $user_id = collect($user1)->implode(',');
        }

        $coupon = coupon::find($request->id);
        $coupon->coupon_code = $request->coupon_code;
        $coupon->description = $request->description;
        $coupon->start_date = date('Y-m-d',strtotime($request->start_date));
        $coupon->end_date = date('Y-m-d',strtotime($request->end_date));
        $coupon->discount_type = $request->discount_type;
        //$coupon->service_id = $service;
        $coupon->amount = $request->amount;
        //$coupon->max_value = $request->max_value;
        $coupon->limit_per_user = $request->limit_per_user;
        $coupon->minimum_order_value = $request->minimum_order_value;
        $coupon->user_type = $request->user_type;
        $coupon->user_id = $user_id;
        $coupon->save();
        return response()->json($coupon);
    }

    public function deletecoupon($id){
        $coupon = coupon::find($id);
        $coupon->delete();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function getcouponservice($id){ 
        $data  = coupon::find($id);
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        $arraydata=array();
        foreach(explode(',',$data->service_id) as $user1){
            $arraydata[]=$user1;
        }
        $output = '';
        foreach ($service as $value){
            if(in_array($value->id , $arraydata))
            {
                $output .='<option selected value="'.$value->id.'">'.$value->service_name_english.'</option>'; 
            }
            else{
                $output .='<option value="'.$value->id.'">'.$value->service_name_english.'</option>'; 
            }
        }
      
      echo $output;
    }
    
    public function getcouponuser($id){ 
        $data  = coupon::find($id);
        $user = customer::all();

        $arraydata=array();
        foreach(explode(',',$data->user_id) as $user1){
            $arraydata[]=$user1;
        }
        $output = '';
        foreach ($user as $value){
            if(in_array($value->id , $arraydata))
            {
                $output .='<option selected value="'.$value->id.'">'.$value->mobile.' - '.$value->first_name.' '.$value->last_name.'</option>'; 
            }
            else{
                $output .='<option value="'.$value->id.'">'.$value->mobile.' - '.$value->first_name.' '.$value->last_name.'</option>';  
            }
        }
      
        echo $output;
    }

}
