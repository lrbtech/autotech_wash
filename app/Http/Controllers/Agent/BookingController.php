<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\colour;
use App\vehicles;
use App\booking;
use App\booking_service;
use App\booking_package;
use App\booking_product;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function booking(){
        return view('agent.booking');
    }
    public function bookingdetails($id){
        $booking = booking::find($id);
        $booking_service = booking_service::where('booking_id',$id)->get();
        $booking_package = booking_package::where('booking_id',$id)->get();
        $booking_product = booking_product::where('booking_id',$id)->get();
        $shop = User::find($booking->shop_id);
        $customer = customer::find($booking->customer_id);
        $vehicle = vehicles::find($booking->vehicle_id);
        $colour = colour::find($vehicle->colour);
        return view('agent.booking_details',compact('booking_service','booking','booking_product','booking_package','customer','shop','vehicle','colour'));
    }

    public function updatebookingpayment($id){
        $booking = booking::find($id);
        $booking->payment_status = 1;
        $booking->save();
        return response()->json('Successfully Update');
    }

    public function updatebookingstatus($id,$status){
        $booking = booking::find($id);
        $booking->status = $status;
        $booking->save();
        return response()->json('Successfully Update');
    }

    public function getbooking($fdate,$tdate,$status){
        $fdate1 = date('Y-m-d', strtotime($fdate));
        $tdate1 = date('Y-m-d', strtotime($tdate));

        $i =DB::table('bookings as b');
        if ( $fdate1 && $fdate != '1' && $tdate1 && $tdate != '1' )
        {
            $i->whereBetween('b.date', [$fdate1, $tdate1]);
        }
        if ( $status != 'status' )
        {
            $i->where('b.status', $status);
        }
        $i->where('b.shop_id', Auth::user()->user_id);
        $i->where(function($query) use ($tdate1,$fdate1){
            $query->where([
                ['b.payment_type', 1],
                ['b.payment_status', 1],
            ]);
            $query->orWhere([
                ['b.payment_type', 0],
            ]);
        });
        $i->orderBy('b.id','DESC');
        $booking = $i->get();
        
        return Datatables::of($booking)
            ->addColumn('customer_details', function ($booking) {
                $customer = customer::find($booking->customer_id);
                return '<td>
                <p>Name : '.$customer->first_name.' '.$customer->last_name.'</p>
                <p>Mobile : '.$customer->mobile.'</p>
                </td>';
            })

            ->addColumn('booking_id', function ($booking) {
                return '<td>'.$booking->booking_id.'</td>';
            }) 
            
            ->addColumn('total', function ($booking) {
                return '<td>'.$booking->total.'</td>';
            }) 
            ->addColumn('payment_type', function ($booking) {
                if ($booking->payment_type == 0) {
                    return '<td>Cash</td>';
                } else {
                    return '<td>Card Payment</td>';
                }
            })
            ->addColumn('payment_status', function ($booking) {
                if ($booking->payment_status == 0) {
                    return '<td>Un Paid</td>';
                } 
                elseif ($booking->payment_status == 1) {
                    return '<td>Paid</td>';
                }
            })
            ->addColumn('status', function ($booking) {
                if ($booking->status == 0) {
                    return '<td>Order Placed</td>';
                } 
                elseif ($booking->status == 1) {
                    return '<td>Order Accepted</td>';
                }
                elseif ($booking->status == 2) {
                    return '<td>Received</td>';
                }
                elseif ($booking->status == 3) {
                    return '<td>Processing</td>';
                }
                elseif ($booking->status == 4) {
                    return '<td>Delivered</td>';
                }
            })
            ->addColumn('booking_date', function ($booking) {
                return '<td>
                <p>' . $booking->date . '</p>
                </td>';
            })

            ->addColumn('action', function ($booking) {
                $output='';
                if($booking->payment_status == 0){
                    $output.='
                    <a onclick="UpdatePayment('.$booking->id.')" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> Paid</a>
                    ';
                }

                if($booking->status == 0){
                    $output.='
                    <a onclick="UpdateStatus('.$booking->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> Order Placed</a>
                    ';
                }
                elseif($booking->status == 1){
                    $output.='
                    <a onclick="UpdateStatus('.$booking->id.',2)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> Pickup</a>
                    ';
                }
                elseif($booking->status == 2){
                    $output.='
                    <a onclick="UpdateStatus('.$booking->id.',3)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> On Processing</a>
                    ';
                }
                elseif($booking->status == 3){
                    $output.='
                    <a onclick="UpdateStatus('.$booking->id.',4)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> Completed</a>
                    ';
                }
                elseif($booking->status == 4){
                    $output.='
                    <a onclick="UpdateStatus('.$booking->id.',5)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> Delivered</a>
                    ';
                }
                return '<div class="dropdown relative"> 
                    <button class="dropdown-toggle button inline-block bg-theme-1 text-white"> Action </button>
                    <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                        <div class="dropdown-box__content box p-2"> 
                        <a href="/agent/booking-details/'.$booking->id.'" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> View Details</a>
                        '.$output.'
                        </div>
                    </div>
                </div>';
            })
            
        ->rawColumns(['customer_details', 'booking_id', 'payment_type','booking_date','total','status','action','payment_status'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }


}
