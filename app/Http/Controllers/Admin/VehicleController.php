<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\brand;
use App\vehicle_type;
use App\vehicles;
use App\vehicle_model;
use App\colour;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;


class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }


    public function brand(){
        $brand = brand::all();
        return view('admin.brand',compact('brand'));
    }

    public function savebrand(Request $request){
        $this->validate($request, [
            'brand_name'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'brand Image Field is Required',
        ]);
        
        $brand = new brand;
        $brand->brand_name = $request->brand_name;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $upload_image);
            $brand->image = $upload_image;
            }
        }

        $brand->save();
        return response()->json('successfully save'); 
    }

    public function updatebrand(Request $request){
        $this->validate($request, [
            'brand_name'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'image.required' => 'Item Image Field is Required',
        ]);
        
        $brand = brand::find($request->id);
        $brand->brand_name = $request->brand_name;
        if($request->image!=""){
            $old_image = "upload_files/".$brand->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $upload_image);
            $brand->image = $upload_image;
            }
        }
        $brand->save();

        return response()->json('successfully update'); 
    }

    public function editbrand($id){
        $brand = brand::find($id);
        return response()->json($brand); 
    }
    
    public function deletebrand($id,$status){
        $brand = brand::find($id);
        $brand->status = $status;
        $brand->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


    public function vehiclemodel($id){
        $model = vehicle_model::where('brand_id',$id)->get();
        $brand = brand::find($id);
        return view('admin.vehicle_model',compact('model','brand'));
    }

    public function savemodel(Request $request){
        $this->validate($request, [
            'model_name'=>'required',
        ]);
        
        $model = new vehicle_model;
        $model->brand_id = $request->brand_id;
        $model->model_name = $request->model_name;
        $model->save();
        return response()->json('successfully save'); 
    }

    public function updatemodel(Request $request){
        $this->validate($request, [
            'model_name'=>'required',
        ]);
        
        $model = vehicle_model::find($request->id);
        $model->brand_id = $request->brand_id;
        $model->model_name = $request->model_name;
        $model->save();

        return response()->json('successfully update'); 
    }

    public function editmodel($id){
        $model = vehicle_model::find($id);
        return response()->json($model); 
    }
    
    public function deletemodel($id,$status){
        $model = vehicle_model::find($id);
        $model->status = $status;
        $model->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function colour(){
        $colour = colour::all();
        return view('admin.colour',compact('colour'));
    }

    public function savecolour(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'code'=>'required',
        ]);
        
        $colour = new colour;
        $colour->name = $request->name;
        $colour->code = $request->code;
        $colour->save();
        return response()->json('successfully save'); 
    }

    public function updatecolour(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'code'=>'required',
        ]);
        
        $colour = colour::find($request->id);
        $colour->name = $request->name;
        $colour->code = $request->code;
        $colour->save();

        return response()->json('successfully update'); 
    }

    public function editcolour($id){
        $colour = colour::find($id);
        return response()->json($colour); 
    }
    
    public function deletecolour($id,$status){
        $colour = colour::find($id);
        $colour->status = $status;
        $colour->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


    public function vehicletype(){
        $vehicle_type = vehicle_type::all();
        return view('admin.vehicle_type',compact('vehicle_type'));
    }

    public function savevehicletype(Request $request){
        $this->validate($request, [
            'vehicle_type'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'vehicle type Image Field is Required',
        ]);
        
        $vehicle_type = new vehicle_type;
        $vehicle_type->vehicle_type = $request->vehicle_type;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $upload_image);
            $vehicle_type->image = $upload_image;
            }
        }

        $vehicle_type->save();
        return response()->json('successfully save'); 
    }

    public function updatevehicletype(Request $request){
        $this->validate($request, [
            'vehicle_type'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'image.required' => 'Item Image Field is Required',
        ]);
        
        $vehicle_type = vehicle_type::find($request->id);
        $vehicle_type->vehicle_type = $request->vehicle_type;
        if($request->image!=""){
            $old_image = "upload_files/".$vehicle_type->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_files/'), $upload_image);
            $vehicle_type->image = $upload_image;
            }
        }
        $vehicle_type->save();

        return response()->json('successfully update'); 
    }

    public function editvehicletype($id){
        $vehicle_type = vehicle_type::find($id);
        return response()->json($vehicle_type); 
    }
    
    public function deletevehicletype($id,$status){
        $vehicle_type = vehicle_type::find($id);
        $vehicle_type->status = $status;
        $vehicle_type->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


}
