<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\service;
use App\booking;
use App\shop_service;
use App\shop_package;
use App\shop_product;
use App\vehicle_type;
use App\service_price;
use App\new_service;
use Hash;
use DB;
use Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function service(){
        $shop_service = shop_service::where('shop_id',Auth::user()->user_id)->get();
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        $vehicle_type = vehicle_type::where('status',0)->get();
        return view('agent.service',compact('service','shop_service','vehicle_type'));
    }

    public function saveservice(Request $request){
        $this->validate($request, [
            'service_id' => 'required|unique:shop_services,service_id,NULL,id,shop_id,'.Auth::user()->user_id,
            'price' => 'required' // max 1000kb
        ]);
        
        $service = new shop_service;
        $service->shop_id = Auth::user()->user_id;
        $service->service_id = $request->service_id;
        $service->price = $request->price;
        $service->save();

        // for ($x=0; $x<count($_POST['price']); $x++) 
        // {
        //     $service_price = new service_price;
        //     $service_price->shop_service_id = $service->id;
        //     $service_price->vehicle_type = $_POST['type_id'][$x];
        //     $service_price->price = $_POST['price'][$x];
        //     $service_price->save();
        // }
        return response()->json('successfully save'); 
    }

    public function updateservice(Request $request){
        $this->validate($request, [
            'service_id' => 'required|unique:shop_services,service_id,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'price' => 'required',
        ]);
        
        $service = shop_service::find($request->id);
        $service->service_id = $request->service_id;
        $service->price = $request->price;
        $service->save();

        // service_price::where('shop_service_id',$service->id)->delete();

        // for ($x=0; $x<count($_POST['price']); $x++) 
        // {
        //     $service_price = new service_price;
        //     $service_price->shop_service_id = $service->id;
        //     $service_price->vehicle_type = $_POST['type_id'][$x];
        //     $service_price->price = $_POST['price'][$x];
        //     $service_price->save();
        // }

        return response()->json('successfully update'); 
    }

    public function editservice($id){
        $service = shop_service::find($id);
        return response()->json($service); 
    }
    
    public function deleteservice($id,$status){
        $service = shop_service::find($id);
        $service->status = $status;
        $service->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function getserviceprice($id){ 
        $data  = shop_service::find($id);
        $service_price = service_price::where('shop_service_id',$id)->get();
        $output='';
        foreach ($service_price as $value){
        $vehicle_type = vehicle_type::find($value->vehicle_type);
        $output.='
        <tr>
            <td class="text-center border-b">
                '.$vehicle_type->vehicle_type.'
                <input value="'.$value->vehicle_type.'" type="hidden" name="type_id[]">
            </td>
            <td class="text-center border-b">
                <div class="col-span-12 sm:col-span-12">
                    <input value="'.$value->price.'" autocomplete="off" type="text" class="input w-full border mt-2 flex-1" name="price[]">
                </div>
            </td>
        </tr>';
        }
        echo $output;
    }


    public function package(){
        $shop_package = shop_package::where('shop_id',Auth::user()->user_id)->get();
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        return view('agent.package',compact('shop_package','service'));
    }

    public function savepackage(Request $request){
        $this->validate($request, [
            'package_name_english' => 'required|unique:shop_packages,package_name_english,NULL,id,shop_id,'.Auth::user()->user_id,
            'package_name_arabic' => 'required|unique:shop_packages,package_name_arabic,NULL,id,shop_id,'.Auth::user()->user_id,
            'service_ids'=>'required',
            'price'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'Package Image Field is Required',
        ]);
        
        $service_ids='';
        $service_id;
        foreach($request->service_ids as $row){
            $service_id[]=$row;
        }
        $service_ids = collect($service_id)->implode(',');

        $package = new shop_package;
        $package->shop_id = Auth::user()->user_id;
        $package->service_ids = $service_ids;
        $package->price = $request->price;
        $package->package_name_english = $request->package_name_english;
        $package->package_name_arabic = $request->package_name_arabic;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $package->image = $upload_image;
            }
        }

        $package->save();
        return response()->json('successfully save'); 
    }

    public function updatepackage(Request $request){
        $this->validate($request, [
            'package_name_english' => 'required|unique:shop_packages,package_name_english,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'package_name_arabic' => 'required|unique:shop_packages,package_name_arabic,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'price'=>'required',
            'service_ids'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'image.required' => 'Item Image Field is Required',
        ]);
        
        $service_ids='';
        $service_id;
        foreach($request->service_ids as $row){
            $service_id[]=$row;
        }
        $service_ids = collect($service_id)->implode(',');

        $package = shop_package::find($request->id);
        $package->service_ids = $service_ids;
        $package->price = $request->price;
        $package->package_name_english = $request->package_name_english;
        $package->package_name_arabic = $request->package_name_arabic;
        if($request->image!=""){
            $old_image = "upload_service/".$package->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $package->image = $upload_image;
            }
        }
        $package->save();

        return response()->json('successfully update'); 
    }

    public function editpackage($id){
        $package = shop_package::find($id);
        return response()->json($package); 
    }
    
    public function deletepackage($id,$status){
        $package = shop_package::find($id);
        $package->status = $status;
        $package->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function getshoppackageservices($id){ 
        $data  = shop_package::find($id);
        $service = service::where('parent_id','!=',0)->get();

        $arraydata=array();
        foreach(explode(',',$data->service_ids) as $service_id){
            $arraydata[]=$service_id;
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


    public function product(){
        $shop_product = shop_product::where('shop_id',Auth::user()->user_id)->get();
        $service = service::where('parent_id','!=',0)->where('status',0)->get();
        return view('agent.product',compact('shop_product','service'));
    }

    public function saveproduct(Request $request){
        $this->validate($request, [
            'product_name_english' => 'required|unique:shop_products,product_name_english,NULL,id,shop_id,'.Auth::user()->user_id,
            'product_name_arabic' => 'required|unique:shop_products,product_name_arabic,NULL,id,shop_id,'.Auth::user()->user_id,
            'price'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'Product Image Field is Required',
        ]);
        
        $product = new shop_product;
        $product->shop_id = Auth::user()->user_id;
        $product->price = $request->price;
        $product->product_name_english = $request->product_name_english;
        $product->product_name_arabic = $request->product_name_arabic;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $product->image = $upload_image;
            }
        }

        $product->save();
        return response()->json('successfully save'); 
    }

    public function updateproduct(Request $request){
        $this->validate($request, [
            'product_name_english' => 'required|unique:shop_products,product_name_english,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'product_name_arabic' => 'required|unique:shop_products,product_name_arabic,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'price'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
        ]);
        
        $product = shop_product::find($request->id);
        $product->price = $request->price;
        $product->product_name_english = $request->product_name_english;
        $product->product_name_arabic = $request->product_name_arabic;
        if($request->image!=""){
            $old_image = "upload_service/".$product->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $product->image = $upload_image;
            }
        }
        $product->save();

        return response()->json('successfully update'); 
    }

    public function editproduct($id){
        $product = shop_product::find($id);
        return response()->json($product); 
    }
    
    public function deleteproduct($id,$status){
        $product = shop_product::find($id);
        $product->status = $status;
        $product->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function newservice(){
        $new_service = new_service::where('shop_id',Auth::user()->user_id)->get();
        $category = service::where('parent_id',0)->get();
        return view('agent.new_service',compact('new_service','category'));
    }

    public function savenewservice(Request $request){
        $this->validate($request, [
            'category' => 'required|unique:new_services,category,NULL,id,shop_id,'.Auth::user()->user_id,
            'service' => 'required|unique:new_services,service,NULL,id,shop_id,'.Auth::user()->user_id,
        ]);
        
        $newservice = new new_service;
        $newservice->shop_id = Auth::user()->user_id;
        $newservice->category = $request->category;
        $newservice->service = $request->service;
        $newservice->save();
        return response()->json('successfully save'); 
    }

    public function updatenewservice(Request $request){
        $this->validate($request, [
            'category' => 'required|unique:new_services,category,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
            'service' => 'required|unique:new_services,service,'.$request->id.',id,shop_id,'.Auth::user()->user_id,
        ]);
        
        $newservice = new_service::find($request->id);
        $newservice->category = $request->category;
        $newservice->service = $request->service;
        $newservice->save();

        return response()->json('successfully update'); 
    }

    public function editnewservice($id){
        $newservice = new_service::find($id);
        return response()->json($newservice); 
    }
    
    public function deletenewservice($id,$status){
        $newservice = new_service::find($id);
        $newservice->status = $status;
        $newservice->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }
}
