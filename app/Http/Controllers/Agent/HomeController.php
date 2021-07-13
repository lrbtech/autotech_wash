<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\shop_service;
use App\User;
use App\customer;
use App\booking;
use App\reviews;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Dubai");
        date_default_timezone_get();
    }

    public function dashboard(){
        $today = date('Y-m-d');
        $cfdate = date('Y-m-d',strtotime('first day of this month'));
        $cldate = date('Y-m-d',strtotime('last day of this month'));
  
        $booking = booking::whereBetween('date', [$cfdate, $cldate])->where('shop_id',Auth::user()->user_id)->count();
        $booking_value = booking::whereBetween('date', [$cfdate, $cldate])->where('shop_id',Auth::user()->user_id)->get()->sum("total");
        $customer = customer::whereBetween('date', [$cfdate, $cldate])->count();
        $reviews = reviews::whereBetween('date', [$cfdate, $cldate])->where('shop_id',Auth::user()->user_id)->count();

        return view('agent.dashboard',compact('booking','booking_value','reviews','customer'));
    }
}
