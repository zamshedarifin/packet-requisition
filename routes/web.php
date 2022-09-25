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

Route::get('/', function () {
    return redirect()->route('user.login');
});


Route::get('sms',function(){
   //send SMS
        $user_mobile = "01843215702";
        $name= 'Zamshedul Arifin';
        $sms_text = "Dear $name,You have a notification from packet requisition.Please Check The Panel For Approval";
        $user = "Pride";
        $pass = "xA33I127";
        $sid = "PrideLtdEng";
        //$sid="PrideLtdBng";
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $param = "user=$user&pass=$pass&sms[0][0]=$user_mobile&sms[0][1]=". $sms_text . "&sms[0][2]=1234567890&sid=$sid";
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_HEADER, 0);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_POST, 1);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $param);
        $response = curl_exec($crl);
        curl_close($crl);
        //send SMS


});


Route::get('clear', function(){
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});




Route::namespace('User')->prefix('user')->name('user.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login')->name('login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/register', 'RegisterController@register');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', 'UserController@index')->name('dashboard');
        Route::match(['get','post'],'/requisition', 'UserController@requisition')->name('requisition');

    });
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/-auth', 'LoginController@showLoginForm')->name('login');
        Route::post('/-auth', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::match(['get','post'],'/requisition-details/{id}', 'DashboardController@requsitionDetails')->name('requsition-details');
        Route::match(['get','post'],'/requisition-view/{id}', 'DashboardController@requsitionViews')->name('requsition-view');
        Route::get('/region-wise-requisition', 'DashboardController@regionWiseRequisition')->name('regionWiseRequisition');
        Route::get('/Zone-wise-Details/{name}', 'DashboardController@zoneWiseDetails')->name('zoneWiseDetails');
    });

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
