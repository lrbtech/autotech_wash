<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\customer;
use App\city;
use App\shop_time;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Mail;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function agent(){
        return view('admin.agent');
    }

    public function viewagent($id){
        $agent = User::find($id);
        $shop_time = shop_time::where('agent_id',$id)->get();
        $city = city::all();
        return view('admin.view_agent',compact('agent','city','shop_time'));
    }

    public function deleteagent($id,$status){
        $user = User::find($id);
        $user->status = $status;
        $user->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

    public function updatetime(Request $request){

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

    public function getagent(){
        $agent = User::orderBy('id','DESC')->where('role_id','admin')->get();
        
        return Datatables::of($agent)
            ->addColumn('name', function ($agent) {
                    return '<td>'.$agent->name.'</td>';
            })

            ->addColumn('mobile', function ($agent) {
                return '<td>
                <p>Mobile : '.$agent->mobile.'</p>
                </td>';
            })

            ->addColumn('email', function ($agent) {
                return '<td>'.$agent->email.'</td>';
            })

            ->addColumn('status', function ($agent) {
                if($agent->status == 0){
                    return '<div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>';
                }
                elseif($agent->status == 1){
                    return '<div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>';
                }
            })

            ->addColumn('action', function ($agent) {
                $output='';
                if($agent->status == 0){
                    $output.='
                    <a onclick="Delete('.$agent->id.',1)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> DeActive </a>'; 
                }
                elseif($agent->status == 1){
                    $output.='
                    <a onclick="Delete('.$agent->id.',0)" href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="trash" class="w-4 h-4 mr-2"></i> Active </a>'; 
                }
                return '<div class="dropdown relative"> 
                    <button class="dropdown-toggle button inline-block bg-theme-1 text-white"> Action </button>
                    <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                        <div class="dropdown-box__content box p-2"> 
                        <a href="/admin/view-agent/'.$agent->id.'" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i  data-feather="edit" class="w-4 h-4 mr-2"></i> View </a>
                        '.$output.'
                        </div>
                    </div>
                </div>';
            })
           
            
        ->rawColumns(['name','mobile', 'email', 'status','action'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }

    public function agentbooking($id){
        $i =DB::table('bookings as b');
        $i->where('b.shop_id',$id);
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

            ->addColumn('shop_details', function ($booking) {
                $shop = User::find($booking->shop_id);
                return '<td>
                <p>Name : '.$shop->busisness_name.'</p>
                <p>Mobile : '.$shop->mobile.'</p>
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
                return '<div class="dropdown relative"> 
                    <button class="dropdown-toggle button inline-block bg-theme-1 text-white"> Action </button>
                    <div class="dropdown-box mt-10 absolute w-48 top-0 left-0 z-20">
                        <div class="dropdown-box__content box p-2"> 
                        <a href="/admin/booking-details/'.$booking->id.'" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> View Details</a>
                        </div>
                    </div>
                </div>';
            })
            
        ->rawColumns(['customer_details','shop_details', 'booking_id', 'payment_type','booking_date','total','status','action'])
        ->addIndexColumn()
        ->make(true);

        //return Datatables::of($orders) ->addIndexColumn()->make(true);
    }


}
