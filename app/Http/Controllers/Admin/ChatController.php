<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\admin_customer;
use Hash;
use Auth;
use DB;
use Validator;
use Mail;
use Carbon\Carbon;
use App\Events\ChatEvent;
use App\Events\ChatAdmin;
use StdClass;
use Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function chatcustomer(){
        $customer = customer::all();
        return view('admin.chat_customer',compact('customer'));
    }

    public function savecustomerchat(Request $request){
        $request->validate([
            'message'=>'required',
        ]);
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
        $admin_customer = new admin_customer;
        $admin_customer->message = $request->message;
        $admin_customer->customer_id = $request->customer_id;
        $admin_customer->date = date('Y-m-d');
        $admin_customer->time = date('h:i A');
        $admin_customer->message_from = 1;
        $admin_customer->save();
        $dateTime = new Carbon($admin_customer->updated_at, new \DateTimeZone('Asia/Dubai'));
        $message =  array(
            'message'=> $admin_customer->message,
            'message_from'=> 1,
            'date'=> $dateTime->diffForHumans(),
            'channel_name'=> $request->customer_id,
        );
        event(new ChatAdmin($message));
  
        return response()->json($request->customer_id); 
      }

    public function getcustomerchat($id){
        $customer = customer::find($id);
        $chat = admin_customer::where('customer_id',$id)->get();

        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
        $time = date("h:i A"); 
        $date = date('Y-m-d'); 

//$output='';
$output='
<div class="flex flex-col sm:flex-row border-b border-gray-200 px-5 py-4">
    <div class="flex items-center">
        <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
            <img class="rounded-full" src="/admin-assets/dist/images/profile-4.jpg">
        </div>
        <div class="ml-3 mr-auto">
            <div class="font-medium text-base">'.$customer->first_name.' '.$customer->last_name.'</div>
            <div class="text-gray-600 text-xs sm:text-sm">
                '.$customer->mobile.'
                <!-- <span class="mx-1">•</span> Online -->
            </div>
        </div>
    </div>
</div>
<div id="chat_view" class="overflow-y-scroll px-5 pt-5 flex-1">';
    foreach($chat as $row){
    $dateTime = new Carbon($row->updated_at, new \DateTimeZone('Asia/Dubai'));
    if($row->message_from == '0'){
    $output.='<div class="chat__box__text-box flex items-end float-left mb-4">
        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
            <img class="rounded-full" src="/admin-assets/dist/images/profile-4.jpg">
        </div>
        <div class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
            '.$row->message.' 
            <div class="mt-1 text-xs text-gray-600">'.$dateTime->diffForHumans().'</div>
        </div>
        <!-- <div class="hidden sm:block dropdown relative ml-3 my-auto">
            <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-gray-500"> <i data-feather="more-vertical" class="w-4 h-4"></i> </a>
            <div class="dropdown-box mt-6 absolute w-40 top-0 right-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i> Reply </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                </div>
            </div>
        </div> -->
    </div>
    <div class="clear-both"></div>';
    }
    else{
    $output.='<div class="chat__box__text-box flex items-end float-right mb-4">
        <!-- <div class="hidden sm:block dropdown relative mr-3 my-auto">
            <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-gray-500"> <i data-feather="more-vertical" class="w-4 h-4"></i> </a>
            <div class="dropdown-box mt-6 absolute w-40 top-0 right-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i> Reply </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                </div>
            </div>
        </div> -->
        <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
            '.$row->message.' 
            <div class="mt-1 text-xs text-theme-25">'.$dateTime->diffForHumans().'</div>
        </div>
        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
            <img class="rounded-full" src="/admin-assets/dist/images/profile-13.jpg">
        </div>
    </div>
    <div class="clear-both"></div>';
    }
    }
$output.='</div>
<form id="chat_form" method="POST">
'.csrf_field().'
<div class="pt-4 pb-10 sm:py-4 flex items-center border-t border-gray-200">
    <input type="hidden" value="'.$customer->id.'" name="customer_id" id="customer_id">
    <textarea id="message" name="message" class="chat__box__input input w-full h-16 resize-none border-transparent px-5 py-3 focus:shadow-none" rows="1" placeholder="Type your message..."></textarea>
    <a onclick="SaveChat()" href="javascript:;" class="w-8 h-8 sm:w-10 sm:h-10 block bg-theme-1 text-white rounded-full flex-none flex items-center justify-center mr-5"> 
    <i data-feather="send" class="w-4 h-4"></i> 
    </a>
</div>
</form>
';
         
        return response()->json(['html'=>$output,'channel_name'=>$customer->id],200); 
    }


    public function viewcustomerchat($id){
        $customer = customer::find($id);
        $chat = admin_customer::where('customer_id',$id)->get();

        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
        $time = date("h:i A"); 
        $date = date('Y-m-d'); 

    $output='';
foreach($chat as $row){
    $dateTime = new Carbon($row->updated_at, new \DateTimeZone('Asia/Dubai'));
    if($row->message_from == '0'){
    $output.='<div class="chat__box__text-box flex items-end float-left mb-4">
        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
            <img class="rounded-full" src="/admin-assets/dist/images/profile-4.jpg">
        </div>
        <div class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
            '.$row->message.' 
            <div class="mt-1 text-xs text-gray-600">'.$dateTime->diffForHumans().'</div>
        </div>
        <!-- <div class="hidden sm:block dropdown relative ml-3 my-auto">
            <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-gray-500"> <i data-feather="more-vertical" class="w-4 h-4"></i> </a>
            <div class="dropdown-box mt-6 absolute w-40 top-0 right-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i> Reply </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                </div>
            </div>
        </div> -->
    </div>
    <div class="clear-both"></div>';
    }
    else{
    $output.='<div class="chat__box__text-box flex items-end float-right mb-4">
        <!-- <div class="hidden sm:block dropdown relative mr-3 my-auto">
            <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-gray-500"> <i data-feather="more-vertical" class="w-4 h-4"></i> </a>
            <div class="dropdown-box mt-6 absolute w-40 top-0 right-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i> Reply </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                </div>
            </div>
        </div> -->
        <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
            '.$row->message.' 
            <div class="mt-1 text-xs text-theme-25">'.$dateTime->diffForHumans().'</div>
        </div>
        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
            <img class="rounded-full" src="/admin-assets/dist/images/profile-13.jpg">
        </div>
    </div>
    <div class="clear-both"></div>';
    }
}
         
        return response()->json(['html'=>$output,'channel_name'=>$customer->id],200); 
    }

}
