<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'customer'],function(){

    //customer
    Route::post('/create-customer', 'Api\UserController@createCustomer');
    Route::post('/verify-customer', 'Api\UserController@verifyCustomer');
    Route::post('/login', 'Api\UserController@customerLogin');
    Route::post('/update-customer', 'Api\UserController@updateCustomer');
    Route::get('/edit-customer/{id}', 'Api\UserController@editCustomer');
    Route::post('/update-firebasekey', 'Api\UserController@updatefirebasekey');

    Route::post('/otp-resend', 'Api\UserController@getApiOtpResend');

    Route::post('/forget-password', 'Api\UserController@forgetPassword');
    Route::post('/reset-password', 'Api\UserController@resetPassword');

    Route::get('/get-city', 'Api\UserController@getcity');
    Route::get('/get-brand', 'Api\UserController@getbrand');
    Route::get('/get-vehicle-model/{brand}', 'Api\UserController@getvehiclemodel');
    Route::get('/get-vehicle-type', 'Api\UserController@getvehicletype');
    Route::get('/get-colours', 'Api\UserController@getcolours');

    Route::post('/save-vehicles', 'Api\UserController@savevehicles');
    Route::post('/update-vehicles', 'Api\UserController@updatevehicles');
    Route::get('/get-vehicles/{user_id}', 'Api\UserController@getvehicles');
    Route::get('/edit-vehicles/{id}', 'Api\UserController@editvehicles');
    Route::get('/delete-vehicles/{id}/{status}', 'Api\UserController@deletevehicles');

    // Route::get('/get-address/{user_id}', 'Api\UserController@getaddress');
    // Route::get('/show-address/{user_id}', 'Api\UserController@showaddress');
    // Route::post('/save-address', 'Api\UserController@saveaddress');
    // Route::post('/update-address', 'Api\UserController@updateaddress');
    // Route::get('/delete-address/{id}', 'Api\UserController@deleteaddress');

    Route::get('/get-category/{type}', 'Api\UserController@getcategory');

    //shops
    Route::get('/get-all-shops/{latitude}/{longitude}/{category}/{date}/{time}/{type}', 'Api\UserController@getallshops');

    Route::get('/get-shop-reviews/{shop_id}', 'Api\UserController@getshopreviews');

    Route::get('/get-service/{shop_id}', 'Api\UserController@getservice');
    Route::get('/get-package/{shop_id}', 'Api\UserController@getpackage');
    Route::get('/get-package-services/{id}', 'Api\UserController@getpackageservices');
    Route::get('/get-product/{shop_id}', 'Api\UserController@getproduct');

    Route::get('/coupon-apply/{id}/{code}/{value}/{shop_id}', 'Api\UserController@couponapply');

    //booking
    Route::post('/save-booking', 'Api\UserController@savebooking');
    Route::post('/save-booking-service', 'Api\UserController@savebookingservice');
    Route::post('/save-booking-product', 'Api\UserController@savebookingproduct');
    Route::post('/save-booking-package', 'Api\UserController@savebookingpackage');

    Route::get('/get-all-booking/{customer_id}', 'Api\UserController@getallbooking');
    Route::get('/get-booking/{id}', 'Api\UserController@getbooking');
    Route::get('/get-booking-service/{id}', 'Api\UserController@getbookingservice');
    Route::get('/get-booking-product/{id}', 'Api\UserController@getbookingproduct');
    Route::get('/get-booking-package/{id}', 'Api\UserController@getbookingpackage');

    Route::get('/get-booking-transaction/{id}', 'Api\UserController@getbookingtransaction');

    Route::get('/get-weeks', 'Api\UserController@getweeks');
    Route::get('/get-available-time-today', 'Api\UserController@getavailabletimetoday');
    Route::get('/get-available-time', 'Api\UserController@getavailabletime');

    Route::POST('/get-access-token', 'Api\UserController@getAccessToken');
    Route::POST('/create-payment-order/{total}/{id}', 'Api\UserController@createPaymentOrder');
    Route::get('/get-retrive-payment/{id}', 'Api\UserController@getRetrivePayment');

    Route::get('/get-all-package', 'Api\UserController@getallpackage');
    Route::get('/get-coupon-code/{customer_id}', 'Api\UserController@getcouponcode');

    Route::get('/get-terms/{lang}', 'Api\UserController@getterms');
    Route::get('/get-privacy/{lang}', 'Api\UserController@getprivacy');
    Route::get('/get-about/{lang}', 'Api\UserController@getabout');

    Route::get('/get-notification/{customer_id}', 'Api\UserController@getnotification');

});


Route::group(['prefix' => 'agent'],function(){

    Route::post('/login', 'Api\AgentController@agentLogin');

    Route::get('/get-list-service', 'Api\AgentController@getlistservice');

    Route::get('/get-service/{shop_id}', 'Api\AgentController@getservice');
    Route::post('/save-service', 'Api\AgentController@saveservice');

    Route::get('/get-package/{shop_id}', 'Api\AgentController@getpackage');
    Route::get('/get-package-services/{id}', 'Api\AgentController@getpackageservices');
    Route::post('/save-package', 'Api\AgentController@savepackage');

    Route::get('/get-product/{shop_id}', 'Api\AgentController@getproduct');
    Route::post('/save-product', 'Api\AgentController@saveproduct');

    Route::get('/get-booking/{shop_id}', 'Api\AgentController@getbooking');
    Route::get('/get-booking-details/{id}', 'Api\AgentController@getbookingdetails');
    Route::get('/get-booking-service/{id}', 'Api\AgentController@getbookingservice');
    Route::get('/get-booking-product/{id}', 'Api\AgentController@getbookingproduct');
    Route::get('/get-booking-package/{id}', 'Api\AgentController@getbookingpackage');

    Route::get('/get-notification/{id}', 'Api\AgentController@getnotification');

});