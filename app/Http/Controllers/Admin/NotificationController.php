<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\push_notification;
use App\customer;
use App\User;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function saveNotification(Request $request){
        $request->validate([
            'title'=>'required',
        ]);

        $customer_id='';
        if($request->send_to == '4'){
            $customer1;
            foreach($request->customer_id as $row){
                $customer1[]=$row;
            }
            $customer_id = collect($customer1)->implode(',');
        }
        $shop_id='';
        if($request->send_to == '3'){
            $shop1;
            foreach($request->shop_id as $row){
                $shop1[]=$row;
            }
            $shop_id = collect($shop1)->implode(',');
        }

        $push_notification = new push_notification;
        $push_notification->shop_id = 'admin';
        $push_notification->title = $request->title;
        $push_notification->expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $push_notification->description = $request->description;
        $push_notification->send_to = $request->send_to;
        if($request->send_to == '4'){
        $push_notification->customer_ids = $customer_id;
        }
        if($request->send_to == '3'){
        $push_notification->shop_ids = $shop_id;
        }
        $push_notification->status = 1;
        $push_notification->save();

        return response()->json('successfully save'); 
    }

    public function saveSendNotification(Request $request){
        $request->validate([
            'title'=>'required',
        ]);

        $customer_id='';
        if($request->send_to == '4'){
            $customer1;
            foreach($request->customer_id as $row){
                $customer1[]=$row;
            }
            $customer_id = collect($customer1)->implode(',');
        }
        $shop_id='';
        if($request->send_to == '3'){
            $shop1;
            foreach($request->shop_id as $row){
                $shop1[]=$row;
            }
            $shop_id = collect($shop1)->implode(',');
        }
        $push_notification = new push_notification;
        $push_notification->shop_id = 'admin';
        $push_notification->title = $request->title;
        $push_notification->expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $push_notification->description = $request->description;
        $push_notification->send_to = $request->send_to;
        if($request->send_to == '4'){
        $push_notification->customer_ids = $customer_id;
        }
        if($request->send_to == '3'){
        $push_notification->shop_ids = $shop_id;
        }
        $push_notification->status = 1;
        $push_notification->save();

        $this->sendNotification($push_notification->id);
        return response()->json('successfully save'); 
    }

    public function updateNotification(Request $request){
        $request->validate([
            'title'=> 'required',
        ]);
        
        $customer_id='';
        if($request->send_to == '4'){
            $customer1;
            foreach($request->customer_id as $row){
                $customer1[]=$row;
            }
            $customer_id = collect($customer1)->implode(',');
        }
        $shop_id='';
        if($request->send_to == '3'){
            $shop1;
            foreach($request->shop_id as $row){
                $shop1[]=$row;
            }
            $shop_id = collect($shop1)->implode(',');
        }
        $push_notification = push_notification::find($request->id);
        $push_notification->title = $request->title;
        $push_notification->expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $push_notification->description = $request->description;
        $push_notification->send_to = $request->send_to;
        if($request->send_to == '4'){
        $push_notification->customer_ids = $customer_id;
        }
        if($request->send_to == '3'){
        $push_notification->shop_ids = $shop_id;
        }
        $push_notification->save();

        return response()->json('successfully update'); 
    }

    public function updateSendNotification(Request $request){
        $request->validate([
            'title'=> 'required',
        ]);
        
        $customer_id='';
        if($request->send_to == '4'){
            $customer1;
            foreach($request->customer_id as $row){
                $customer1[]=$row;
            }
            $customer_id = collect($customer1)->implode(',');
        }
        $shop_id='';
        if($request->send_to == '3'){
            $shop1;
            foreach($request->shop_id as $row){
                $shop1[]=$row;
            }
            $shop_id = collect($shop1)->implode(',');
        }
        $push_notification = push_notification::find($request->id);
        $push_notification->title = $request->title;
        $push_notification->expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $push_notification->description = $request->description;
        $push_notification->send_to = $request->send_to;
        if($request->send_to == '4'){
        $push_notification->customer_ids = $customer_id;
        }
        if($request->send_to == '3'){
        $push_notification->shop_ids = $shop_id;
        }
        $push_notification->save();

        $this->sendNotification($push_notification->id);

        return response()->json('successfully update'); 
    }

    public function Notification(){
        $push_notification = push_notification::all();
        $customer = customer::all();
        $user = User::where('role_id','admin')->where('status',0)->get();
        return view('admin.push_notification',compact('push_notification','customer','user'));
    }

    public function editNotification($id){
        $push_notification = push_notification::find($id);
        return response()->json($push_notification); 
    }
    
    public function deleteNotification($id){
        $push_notification = push_notification::find($id);
        $push_notification->delete();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


public function sendNotification($id){
    //$body = "Pickup date/time : ".$request->pickup_date.'/'.$request->pickup_time.' Delivery Type :'.$request->delivery_option;
    $push_notification = push_notification::find($id);

    if($push_notification->send_to == '1'){
        $shop = User::where('firebase_key','!=',null)->get();
        foreach($shop as $shop1){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\r\n\"to\":\"$shop1->firebase_key\",\r\n \"notification\" : {\r\n  \"sound\" : \"default\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n },\r\n \"data\" : {\r\n  \"sound\" : \"default\",\r\n  \"click_action\" : \"FLUTTER_NOTIFICATION_CLICK\",\r\n  \"id\" : \"$push_notification->id\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n }\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Authorization: key=AAAAJsgpkGE:APA91bG774TdUb5ctWsrbJ6qRbh0-1keAzgxTFaDOxiMgICdL7CQXuqp1YlgRPse7OFY0eTsVhYZwNstINZdiGEduwBHYOHwr6xOqQ-rPzXd1Vj2M6R98l9IlfDOeT9_boLqHSdL9qc0",
            "Content-Type: application/json"
        ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        }
    }
    elseif($push_notification->send_to == '2'){
        $customers = customer::where('firebase_key','!=',null)->get();
        foreach($customers as $customer){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\r\n\"to\":\"$customer->firebase_key\",\r\n \"notification\" : {\r\n  \"sound\" : \"default\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n },\r\n \"data\" : {\r\n  \"sound\" : \"default\",\r\n  \"click_action\" : \"FLUTTER_NOTIFICATION_CLICK\",\r\n  \"id\" : \"$push_notification->id\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n }\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Authorization: key=AAAAJsgpkGE:APA91bG774TdUb5ctWsrbJ6qRbh0-1keAzgxTFaDOxiMgICdL7CQXuqp1YlgRPse7OFY0eTsVhYZwNstINZdiGEduwBHYOHwr6xOqQ-rPzXd1Vj2M6R98l9IlfDOeT9_boLqHSdL9qc0",
            "Content-Type: application/json"
        ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        }
    }
    elseif($push_notification->send_to == '3'){
        foreach(explode(',',$push_notification->shop_ids) as $shop_id){
            $shop = User::find($shop_id);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\r\n\"to\":\"$shop->firebase_key\",\r\n \"notification\" : {\r\n  \"sound\" : \"default\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n },\r\n \"data\" : {\r\n  \"sound\" : \"default\",\r\n  \"click_action\" : \"FLUTTER_NOTIFICATION_CLICK\",\r\n  \"id\" : \"$push_notification->id\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=AAAAJsgpkGE:APA91bG774TdUb5ctWsrbJ6qRbh0-1keAzgxTFaDOxiMgICdL7CQXuqp1YlgRPse7OFY0eTsVhYZwNstINZdiGEduwBHYOHwr6xOqQ-rPzXd1Vj2M6R98l9IlfDOeT9_boLqHSdL9qc0",
                "Content-Type: application/json"
            ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            }
    }
    elseif($push_notification->send_to == '4'){
        foreach(explode(',',$push_notification->customer_ids) as $customer_id){
        $customer = customer::find($customer_id);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\r\n\"to\":\"$customer->firebase_key\",\r\n \"notification\" : {\r\n  \"sound\" : \"default\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n },\r\n \"data\" : {\r\n  \"sound\" : \"default\",\r\n  \"click_action\" : \"FLUTTER_NOTIFICATION_CLICK\",\r\n  \"id\" : \"$push_notification->id\",\r\n  \"body\" :  \"$push_notification->description\",\r\n  \"title\" : \"$push_notification->title\",\r\n  \"content_available\" : true,\r\n  \"priority\" : \"high\"\r\n }\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Authorization: key=AAAAJsgpkGE:APA91bG774TdUb5ctWsrbJ6qRbh0-1keAzgxTFaDOxiMgICdL7CQXuqp1YlgRPse7OFY0eTsVhYZwNstINZdiGEduwBHYOHwr6xOqQ-rPzXd1Vj2M6R98l9IlfDOeT9_boLqHSdL9qc0",
            "Content-Type: application/json"
        ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        }
    }
        
    

    return response()->json(['message'=>'Successfully Send'],200); 
}




public function getNotificationshop($id){ 
    $data  = push_notification::find($id);
    $user = User::all();

  $arraydata=array();
  foreach(explode(',',$data->shop_ids) as $shop1){
    $arraydata[]=$shop1;
  }
  $output = '';
    foreach ($user as $value){
        if(in_array($value->id , $arraydata))
        {
            $output .='<option selected="true" value="'.$value->id.'">'.$value->busisness_name.'</option>'; 
        }
        else{
            $output .='<option value="'.$value->id.'">'.$value->busisness_name.'</option>'; 
        }
    }
  
  echo $output;
}

public function getNotificationCustomer($id){ 
    $data  = push_notification::find($id);
    $user = customer::all();

  $arraydata=array();
  foreach(explode(',',$data->customer_ids) as $user1){
    $arraydata[]=$user1;
  }
  $output = '';
    foreach ($user as $value){
        if(in_array($value->id , $arraydata))
        {
            $output .='<option selected="true" value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>'; 
        }
        else{
            $output .='<option value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>'; 
        }
    }
  
  echo $output;
  
}


}
