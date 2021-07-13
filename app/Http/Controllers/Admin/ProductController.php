<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\booking;
use App\booking_service;
use App\booking_package;
use App\shop_product;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function product(){
        return view('admin.product_request');
    }

    public function getproduct(){
        $shop_product =DB::table('shop_products as b');
        $shop_product->orderBy('b.id','DESC');
        
        return Datatables::of($shop_product)
            ->addColumn('shop_details', function ($shop_product) {
                $shop = User::find($shop_product->shop_id);
                return '<td>
                <p>Name : '.$shop->busisness_name.'</p>
                <p>Mobile : '.$shop->mobile.'</p>
                </td>';
            })

            ->addColumn('product', function ($shop_product) {
                return '<td>
                <p>English : '.$shop_product->product_name_english.'</p>
                <p>Arabic : '.$shop_product->product_name_arabic.'</p>
                </td>';
            })

            ->addColumn('image', function ($shop_product) {
                return '<td><img class="tooltip" src="/upload_service/'.$shop_product->image.'"></td>';
            }) 
            
            ->addColumn('price', function ($shop_product) {
                return '<td>AED '.$shop_product->price.'</td>';
            }) 

            ->addColumn('status', function ($shop_product) {
                if ($shop_product->admin_status == 0) {
                    return '<td>New Request</td>';
                } 
                else if ($shop_product->admin_status == 1) {
                    return '<td>Approved</td>';
                } 
                else if ($shop_product->admin_status == 2) {
                    return '<td>Denied</td>';
                } 
            })

            ->addColumn('action', function ($shop_product) {
                $output='';
                if($shop_product->admin_status == 0){
                    $output.='
                    <a onclick="UpdateStatus('.$shop_product->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
                }
                elseif($shop_product->admin_status == 1){
                    $output.='
                    <a onclick="UpdateStatus('.$shop_product->id.',2)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Denied </a>'; 
                }
                elseif($shop_product->admin_status == 2){
                    $output.='
                    <a onclick="UpdateStatus('.$shop_product->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
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
            
        ->rawColumns(['product','shop_details', 'status', 'price','image','action'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }

    public function updateproductstatus($id,$status){
        $shop_product = shop_product::find($id);
        $shop_product->admin_status = $status;
        $shop_product->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }


}
