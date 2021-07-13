<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\service;
use App\new_service;
use App\User;
use Hash;
use DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function service(){
        $service = service::where('parent_id',0)->get();
        return view('admin.service',compact('service'));
    }

    public function saveservice(Request $request){
        $this->validate($request, [
            'service_name_english'=>'required',
            'service_name_arabic'=>'required',
            'type'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'Service Image Field is Required',
            'type.required' => 'Category Type Field is Required',
        ]);
        
        $service = new service;
        $service->service_name_english = $request->service_name_english;
        $service->service_name_arabic = $request->service_name_arabic;
        $service->type = $request->type;
        $service->price = $request->price;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $service->image = $upload_image;
            }
        }
        $service->save();

        return response()->json('successfully update'); 
    }

    public function updateservice(Request $request){
        $this->validate($request, [
            'service_name_english'=>'required',
            'service_name_arabic'=>'required',
            'type'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'image.required' => 'Item Image Field is Required',
            'type.required' => 'Category Type Field is Required',
        ]);
        
        $service = service::find($request->id);
        $service->service_name_english = $request->service_name_english;
        $service->service_name_arabic = $request->service_name_arabic;
        $service->type = $request->type;
        $service->price = $request->price;
        if($request->image!=""){
            $old_image = "upload_service/".$service->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $service->image = $upload_image;
            }
        }
        $service->save();

        return response()->json('successfully update'); 
    }

    public function subservice($id){
        $service = service::where('parent_id',$id)->get();
        return view('admin.sub_service',compact('service','id'));
    }

    public function savesubservice(Request $request){
        $this->validate($request, [
            'service_name_english'=>'required',
            'service_name_arabic'=>'required',
            //'price'=>'required',
            'image' => 'required|mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            'image.required' => 'Service Image Field is Required',
        ]);
        
        $service = new service;
        $service->service_name_english = $request->service_name_english;
        $service->service_name_arabic = $request->service_name_arabic;
        $service->parent_id = $request->parent_id;
       // $service->price = $request->price;
        if($request->image!=""){
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $service->image = $upload_image;
            }
        }

        $service->save();
        return response()->json('successfully save'); 
    }

    public function updatesubservice(Request $request){
        $this->validate($request, [
            'service_name_english'=>'required',
            'service_name_arabic'=>'required',
            //'price'=>'required',
            'image' => 'mimes:jpeg,jpg,png,pdf|max:1000', // max 1000kb
          ],[
            'image.mimes' => 'Only jpeg, png and jpg images are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 1MB',
            //'image.required' => 'Item Image Field is Required',
        ]);
        
        $service = service::find($request->id);
        $service->service_name_english = $request->service_name_english;
        $service->service_name_arabic = $request->service_name_arabic;
        //$service->price = $request->price;
        if($request->image!=""){
            $old_image = "upload_service/".$service->image;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
            if($request->file('image')!=""){
            $image = $request->file('image');
            $upload_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload_service/'), $upload_image);
            $service->image = $upload_image;
            }
        }
        $service->save();

        return response()->json('successfully update'); 
    }

    public function editsubservice($id){
        $service = service::find($id);
        return response()->json($service); 
    }
    
    public function deletesubservice($id,$status){
        $service = service::find($id);
        $service->status = $status;
        $service->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function newservice(){
        return view('admin.new_service');
    }

    public function getnewservice(){
        $new_service =DB::table('new_services as s');
        $new_service->orderBy('s.id','DESC');
        
        return Datatables::of($new_service)
            ->addColumn('shop_details', function ($new_service) {
                $shop = User::find($new_service->shop_id);
                return '<td>
                <p>Name : '.$shop->busisness_name.'</p>
                <p>Mobile : '.$shop->mobile.'</p>
                </td>';
            })

            ->addColumn('category', function ($new_service) {
                return '<td>
                <p>'.$new_service->category.'</p>
                </td>';
            })

            ->addColumn('service', function ($new_service) {
                return '<td>
                <p>'.$new_service->service.'</p>
                </td>';
            })

            ->addColumn('status', function ($new_service) {
                if ($new_service->admin_status == 0) {
                    return '<td>New Request</td>';
                } 
                else if ($new_service->admin_status == 1) {
                    return '<td>Approved</td>';
                } 
                else if ($new_service->admin_status == 2) {
                    return '<td>Denied</td>';
                } 
            })

            ->addColumn('action', function ($new_service) {
                $output='';
                if($new_service->admin_status == 0){
                    $output.='
                    <a onclick="UpdateStatus('.$new_service->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
                }
                elseif($new_service->admin_status == 1){
                    $output.='
                    <a onclick="UpdateStatus('.$new_service->id.',2)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Denied </a>'; 
                }
                elseif($new_service->admin_status == 2){
                    $output.='
                    <a onclick="UpdateStatus('.$new_service->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
                }
                return '<div class="dropdown relative"> 
                    <button class="dropdown-toggle button inline-block bg-theme-1 text-white"> Action </button>
                    <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                        <div class="dropdown-box__content box p-2"> 
                        '.$output.'
                        </div>
                    </div>
                </div>';
            })
            
        ->rawColumns(['category','shop_details', 'status', 'service','action'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }

    public function updatenewservicestatus($id,$status){
        $new_service = new_service::find($id);
        $new_service->admin_status = $status;
        $new_service->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

}
