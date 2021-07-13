<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\city;
use Auth;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function savecity(Request $request){
        $request->validate([
            'city'=>'required',
        ]); 

        $city = new city;
        $city->city = $request->city;
        $city->parent_id = 0;
        $city->save();
        return response()->json('successfully save'); 
    }
    public function updatecity(Request $request){
        $request->validate([
            'city'=> 'required',
        ]);
        
        $city = city::find($request->id);
        $city->city = $request->city;
        $city->parent_id = 0;
        $city->save();
        return response()->json('successfully update'); 
    }

    public function city(){
        $city = city::where('parent_id',0)->get();
        return view('admin.city',compact('city'));
    }

    public function editcity($id){
        $city = city::find($id);
        return response()->json($city); 
    }
    
    public function deletecity($id,$status){
        $city = city::find($id);
        $city->status = $status;
        $city->save();
        return response()->json(['message'=>'Successfully Delete'],200); 
    }

}
