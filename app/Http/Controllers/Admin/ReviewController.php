<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\reviews;
use App\booking;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function reviews(){
        $shop = User::all();
        return view('admin.reviews',compact('shop'));
    }

    public function deletereviews($id,$status){
        $reviews = reviews::find($id);
        $reviews->status = $status;
        $reviews->save();
        return response()->json(['message'=>'Successfully Update'],200); 
    }

    public function getreviews($fdate,$tdate,$shop_id){
        $fdate1 = date('Y-m-d', strtotime($fdate));
        $tdate1 = date('Y-m-d', strtotime($tdate));

        $i =DB::table('reviews as r');
        if ( $fdate1 && $fdate != '1' && $tdate1 && $tdate != '1' )
        {
            $i->whereBetween('r.date', [$fdate1, $tdate1]);
        }
        if ( $shop_id != 'shop' )
        {
            $i->where('r.shop_id', $shop_id);
        }
        $i->orderBy('r.id','DESC');
        $reviews = $i->get();
        
        return Datatables::of($reviews)
            ->addColumn('customer_details', function ($reviews) {
                $customer = customer::find($reviews->customer_id);
                return '<td>
                <p>Name : '.$customer->first_name.' '.$customer->last_name.'</p>
                <p>Mobile : '.$customer->mobile.'</p>
                </td>';
            })
            ->addColumn('shop_details', function ($reviews) {
                $shop = User::find($reviews->shop_id);
                return '<td>
                <p>Name : '.$shop->busisness_name.'</p>
                <p>Mobile : '.$shop->mobile.'</p>
                </td>';
            })
            ->addColumn('booking_id', function ($reviews) {
                return '<td>'.$reviews->booking_id.'</td>';
            }) 
            ->addColumn('reviews', function ($reviews) {
                $output='';
                for($i=0;$i<$reviews->reviews;$i++){
                $output.='<span class="fa fa-star checked"></span>';
                }
                $output.='';
                return $output;
            }) 
            ->addColumn('comments', function ($reviews) {
                return '<td>'.$reviews->comments.'</td>';
            }) 
            ->addColumn('date', function ($reviews) {
                return '<td>
                <p>'.date('d-m-Y',strtotime($reviews->date)).'</p>
                </td>';
            })
            ->addColumn('status', function ($reviews) {
                if($reviews->status == 0){
                    return '<div class="flex items-center justify-center text-theme-6">Pending </div>';
                }
                elseif($reviews->status == 1){
                    return '<div class="flex items-center justify-center text-theme-9">Approved </div>';
                }
                elseif($reviews->status == 2){
                    return '<div class="flex items-center justify-center text-theme-6">Denied </div>';
                }
            })

            ->addColumn('action', function ($reviews) {
                $output='';
                if($reviews->status == 0){
                    $output.='
                    <a onclick="Delete('.$reviews->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
                }
                elseif($reviews->status == 1){
                    $output.='
                    <a onclick="Delete('.$reviews->id.',2)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Denied </a>'; 
                }
                elseif($reviews->status == 2){
                    $output.='
                    <a onclick="Delete('.$reviews->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Approved </a>'; 
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
            
        ->rawColumns(['customer_details','shop_details', 'booking_id','date','reviews','comments','status','action'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }

}
