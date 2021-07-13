<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\reviews;
use App\customer;
use App\shop_time;
use App\User;
use App\booking;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }
    public function storetime(){
        $agent_id = Auth::user()->id;
        $shop_time = shop_time::where('agent_id',Auth::user()->user_id)->get();
        return view('agent.shop_time',compact('shop_time','agent_id'));
    }

    public function updatestoretime(Request $request){
        for ($x=0; $x<count($_POST['timing_id']); $x++) 
        {
            $shop_time = shop_time::find($_POST['timing_id'][$x]);
            $shop_time->open_time = $_POST['open_time'][$x];
            $shop_time->close_time = $_POST['close_time'][$x];
            $shop_time->status = $_POST['status'][$x];
            $shop_time->save();
        }
        return response()->json('Successfully Update'); 
    }

    public function reviews(){
        $shop = User::all();
        return view('agent.reviews',compact('shop'));
    }

    public function getreviews($fdate,$tdate){
        $fdate1 = date('Y-m-d', strtotime($fdate));
        $tdate1 = date('Y-m-d', strtotime($tdate));

        $i =DB::table('reviews as r');
        if ( $fdate1 && $fdate != '1' && $tdate1 && $tdate != '1' )
        {
            $i->whereBetween('r.date', [$fdate1, $tdate1]);
        }
        $i->where('r.shop_id',Auth::user()->user_id);
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
            
        ->rawColumns(['customer_details', 'booking_id','date','reviews','comments','status'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }

}
