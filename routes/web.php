<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return 'optimize cleared';
});

Route::get('/agent-register', 'HomeController@AgentRegister');
Route::POST('/save-agent-register', 'HomeController@saveAgentRegister');
Route::POST('/agent-basic-validate', 'HomeController@AgentBasicValidate');
Route::POST('/agent-contact-validate', 'HomeController@AgentContactValidate');
Route::get('/agent-create-password/{id}', 'HomeController@agentCreatePassword');
Route::POST('/agent-update-password', 'HomeController@agentUpdatePassword');

Route::get('/', 'HomeController@home');
Route::get('/home', 'HomeController@home');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/faq', 'HomeController@faq');
Route::get('/service', 'HomeController@service');
Route::get('/car-wash-services', 'HomeController@carwashservices');
Route::get('/garage-services', 'HomeController@garageservices');
Route::get('/pickup-services', 'HomeController@pickupservices');

Route::get('/booking-print/{id}', 'HomeController@bookingprint');

Auth::routes();

Route::group(['prefix' => 'admin'],function(){

    Route::get('/login', 'AdminLogin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminLogin\LoginController@login')->name('admin.login.submit');
	Route::post('/logout', 'AdminLogin\LoginController@logout')->name('admin.logout');
	  // Password reset routes
    Route::post('/password/email', 'AdminLogin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'AdminLogin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'AdminLogin\ResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'AdminLogin\ResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::get('/dashboard', 'Admin\HomeController@dashboard')->name('admin.dashboard');

    Route::get('/service', 'Admin\ServiceController@service');
    Route::POST('/save-service', 'Admin\ServiceController@saveservice');
    Route::POST('/update-service', 'Admin\ServiceController@updateservice');

    Route::get('/sub-service/{id}', 'Admin\ServiceController@subservice');
    Route::POST('/save-sub-service', 'Admin\ServiceController@savesubservice');
    Route::POST('/update-sub-service', 'Admin\ServiceController@updatesubservice');
    Route::get('/edit-sub-service/{id}', 'Admin\ServiceController@editsubservice');
    Route::get('/delete-sub-service/{id}/{status}', 'Admin\ServiceController@deletesubservice');

    Route::get('/city', 'Admin\CityController@city');
    Route::POST('/save-city', 'Admin\CityController@savecity');
    Route::POST('/update-city', 'Admin\CityController@updatecity');
    Route::get('/edit-city/{id}', 'Admin\CityController@editcity');
    Route::get('/delete-city/{id}/{status}', 'Admin\CityController@deletecity');

    Route::get('/customer', 'Admin\CustomerController@customer');
    Route::POST('/get-customer', 'Admin\CustomerController@getcustomer');
    Route::get('/delete-customer/{id}/{status}', 'Admin\CustomerController@deletecustomer');
    Route::get('/view-customer/{id}', 'Admin\CustomerController@viewcustomer');
    Route::post('/customer-booking/{id}', 'Admin\CustomerController@customerbooking');

    Route::get('/agent', 'Admin\AgentController@agent');
    Route::get('/view-agent/{id}', 'Admin\AgentController@viewagent');
    Route::POST('/get-agent', 'Admin\AgentController@getagent');
    Route::get('/delete-agent/{id}/{status}', 'Admin\AgentController@deleteagent');

    Route::post('/agent-booking/{id}', 'Admin\AgentController@agentbooking');

    Route::POST('/update-time', 'Admin\AgentController@updatetime');


    // coupon Management
	Route::get('/coupon','Admin\CouponController@index');
	Route::get('/add-coupon','Admin\CouponController@addcoupon');
	Route::get('/view-coupon/{id}','Admin\CouponController@viewcoupon');
	Route::post('/coupon-save','Admin\CouponController@savecoupon');
	Route::post('/coupon-update','Admin\CouponController@updatecoupon');
	Route::get('/edit-coupon/{id}','Admin\CouponController@editcoupon');
	Route::get('/delete-coupon/{id}','Admin\CouponController@deletecoupon');
	Route::get('/get_coupon_service/{id}','Admin\CouponController@getcouponservice');
	Route::get('/get_coupon_user/{id}','Admin\CouponController@getcouponuser');

    Route::get('/brand', 'Admin\VehicleController@brand');
    Route::POST('/save-brand', 'Admin\VehicleController@savebrand');
    Route::POST('/update-brand', 'Admin\VehicleController@updatebrand');
    Route::get('/edit-brand/{id}', 'Admin\VehicleController@editbrand');
    Route::get('/delete-brand/{id}/{status}', 'Admin\VehicleController@deletebrand');

    Route::get('/colour', 'Admin\VehicleController@colour');
    Route::POST('/save-colour', 'Admin\VehicleController@savecolour');
    Route::POST('/update-colour', 'Admin\VehicleController@updatecolour');
    Route::get('/edit-colour/{id}', 'Admin\VehicleController@editcolour');
    Route::get('/delete-colour/{id}/{status}', 'Admin\VehicleController@deletecolour');

    Route::get('/vehicle-model/{brand_id}', 'Admin\VehicleController@vehiclemodel');
    Route::POST('/save-model', 'Admin\VehicleController@savemodel');
    Route::POST('/update-model', 'Admin\VehicleController@updatemodel');
    Route::get('/edit-model/{id}', 'Admin\VehicleController@editmodel');
    Route::get('/delete-model/{id}/{status}', 'Admin\VehicleController@deletemodel');

    Route::get('/vehicle-type', 'Admin\VehicleController@vehicletype');
    Route::POST('/save-vehicle-type', 'Admin\VehicleController@savevehicletype');
    Route::POST('/update-vehicle-type', 'Admin\VehicleController@updatevehicletype');
    Route::get('/edit-vehicle-type/{id}', 'Admin\VehicleController@editvehicletype');
    Route::get('/delete-vehicle-type/{id}/{status}', 'Admin\VehicleController@deletevehicletype');

    Route::get('/booking', 'Admin\BookingController@booking');
    Route::POST('/get-booking/{date1}/{date2}/{shop_id}/{status}', 'Admin\BookingController@getbooking');
    Route::get('/booking-details/{id}', 'Admin\BookingController@bookingdetails');

    Route::get('/reviews', 'Admin\ReviewController@reviews');
    Route::POST('/get-reviews/{date1}/{date2}/{shop_id}', 'Admin\ReviewController@getreviews');
    Route::get('/delete-reviews/{id}/{status}', 'Admin\ReviewController@deletereviews');

    Route::get('/product', 'Admin\ProductController@product');
    Route::POST('/get-product', 'Admin\ProductController@getproduct');
    Route::get('/update-product-status/{id}/{status}', 'Admin\ProductController@updateproductstatus');

    Route::get('/new-service', 'Admin\ServiceController@newservice');
    Route::POST('/get-new-service', 'Admin\ServiceController@getnewservice');
    Route::get('/update-new-service-status/{id}/{status}', 'Admin\ServiceController@updatenewservicestatus');

    Route::get('/terms', 'Admin\SettingsController@terms');
    Route::POST('/update-terms', 'Admin\SettingsController@updateterms');

    Route::get('/app-terms', 'Admin\SettingsController@appterms');
    Route::POST('/update-app-terms', 'Admin\SettingsController@updateappterms');

    Route::get('/app-privacy', 'Admin\SettingsController@appprivacy');
    Route::POST('/update-app-privacy', 'Admin\SettingsController@updateappprivacy');

    Route::get('/app-about', 'Admin\SettingsController@appabout');
    Route::POST('/update-app-about', 'Admin\SettingsController@updateappabout');

    Route::get('/change-password', 'Admin\SettingsController@changepassword');
    Route::POST('/update-password', 'Admin\SettingsController@updatepassword');

    //notification
	Route::POST('/save-notification', 'Admin\NotificationController@saveNotification');
	Route::POST('/save-send-notification', 'Admin\NotificationController@saveSendNotification');
	Route::POST('/update-notification', 'Admin\NotificationController@updateNotification');
	Route::POST('/update-send-notification', 'Admin\NotificationController@updateSendNotification');
	Route::get('/notification/{id}', 'Admin\NotificationController@editNotification');
	Route::get('/push-notification', 'Admin\NotificationController@Notification');
	Route::get('/notification-delete/{id}', 'Admin\NotificationController@deleteNotification');
	Route::get('/notification-send/{id}', 'Admin\NotificationController@sendNotification');

	Route::get('/get-notification-shop/{id}', 'Admin\NotificationController@getNotificationshop');
	Route::get('/get-notification-customer/{id}', 'Admin\NotificationController@getNotificationCustomer');

});

Route::group(['prefix' => 'agent'],function(){

    Route::get('/dashboard', 'Agent\HomeController@dashboard');

    Route::get('/service', 'Agent\ServiceController@service');
    Route::POST('/save-service', 'Agent\ServiceController@saveservice');
    Route::POST('/update-service', 'Agent\ServiceController@updateservice');
    Route::get('/edit-service/{id}', 'Agent\ServiceController@editservice');
    Route::get('/delete-service/{id}/{status}', 'Agent\ServiceController@deleteservice');
    Route::get('/get-service-price/{id}', 'Agent\ServiceController@getserviceprice');

    Route::get('/product', 'Agent\ServiceController@product');
    Route::POST('/save-product', 'Agent\ServiceController@saveproduct');
    Route::POST('/update-product', 'Agent\ServiceController@updateproduct');
    Route::get('/edit-product/{id}', 'Agent\ServiceController@editproduct');
    Route::get('/delete-product/{id}/{status}', 'Agent\ServiceController@deleteproduct');

    Route::get('/new-service', 'Agent\ServiceController@newservice');
    Route::POST('/save-new-service', 'Agent\ServiceController@savenewservice');
    Route::POST('/update-new-service', 'Agent\ServiceController@updatenewservice');
    Route::get('/edit-new-service/{id}', 'Agent\ServiceController@editnewservice');
    Route::get('/delete-new-service/{id}/{status}', 'Agent\ServiceController@deletenewservice');

    Route::get('/staff', 'Agent\SettingsController@staff');
    Route::POST('/save-staff', 'Agent\SettingsController@savestaff');
    Route::POST('/update-staff', 'Agent\SettingsController@updatestaff');
    Route::get('/edit-staff/{id}', 'Agent\SettingsController@editstaff');
    Route::get('/delete-staff/{id}/{status}', 'Agent\SettingsController@deletestaff');

    Route::get('/package', 'Agent\ServiceController@package');
    Route::POST('/save-package', 'Agent\ServiceController@savepackage');
    Route::POST('/update-package', 'Agent\ServiceController@updatepackage');
    Route::get('/edit-package/{id}', 'Agent\ServiceController@editpackage');
    Route::get('/delete-package/{id}/{status}', 'Agent\ServiceController@deletepackage');
    Route::get('/get-shop-package-services/{id}', 'Agent\ServiceController@getshoppackageservices');

    Route::get('/booking', 'Agent\BookingController@booking');
    Route::POST('/get-booking/{date1}/{date2}/{status}', 'Agent\BookingController@getbooking');
    Route::get('/booking-details/{id}', 'Agent\BookingController@bookingdetails');

    Route::get('/store-time', 'Agent\ReviewController@storetime');
	Route::POSt('/update-store-time', 'Agent\ReviewController@updatestoretime');

    Route::get('/change-password', 'Agent\SettingsController@changepassword');
    Route::POST('/update-password', 'Agent\SettingsController@updatepassword');

    Route::get('/profile', 'Agent\SettingsController@profile');
    Route::POST('/update-profile', 'Agent\SettingsController@updateprofile');

    Route::get('/reviews', 'Agent\ReviewController@reviews');
    Route::POST('/get-reviews/{date1}/{date2}', 'Agent\ReviewController@getreviews');

    // coupon Management
	Route::get('/coupon','Agent\CouponController@index');
	Route::get('/add-coupon','Agent\CouponController@addcoupon');
	Route::get('/view-coupon/{id}','Agent\CouponController@viewcoupon');
	Route::post('/coupon-save','Agent\CouponController@savecoupon');
	Route::post('/coupon-update','Agent\CouponController@updatecoupon');
	Route::get('/edit-coupon/{id}','Agent\CouponController@editcoupon');
	Route::get('/delete-coupon/{id}','Agent\CouponController@deletecoupon');
	Route::get('/get_coupon_service/{id}','Agent\CouponController@getcouponservice');
	Route::get('/get_coupon_user/{id}','Agent\CouponController@getcouponuser');

});
