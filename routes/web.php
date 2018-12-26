<?php

Auth::routes();

const Admin = "Admin";
const Loan = "Loans";
const Lender = "Lender";
const Report = "Report";
const Guarantor = "Guarantor"; //nhà đảm bảo
const Company = "Company"; //Công ty
const Maketting = "Maketting";
const Api = "Api";
const LogCall = "LogCall";

// Used for dev by Quynh
$isDev = Request::get('is_debug','');
if($isDev == 'tech_code'){
    Session::put('is_debug_of_tech', '13031984');
    Config::set('compile.debug',true);
}
if(Session::has('is_debug_of_tech')){
    Config::set('compile.debug',true);
}
require __DIR__.'/site.php';

//Quan tri CMS cho admin
Route::get('', array('as' => 'admin.login','uses' => Admin.'\AdminLoginController@getLogin'));
Route::post('',  array('as' => 'admin.login','uses' => Admin.'\AdminLoginController@postLogin'));
Route::get('/quan-tri.html', array('as' => 'admin.login','uses' => Admin.'\AdminLoginController@getLogin'));
Route::post('/quan-tri.html',  array('as' => 'admin.login','uses' => Admin.'\AdminLoginController@postLogin'));

Route::group(array('prefix' => 'manager', 'before' => ''), function(){
	require __DIR__.'/admin.php';
});

//Router Loan
Route::group(array('prefix' => 'manager', 'before' => ''), function(){
	require __DIR__.'/loan.php';
});

//Router Lender
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/lender.php';
});

//Router Report
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/report.php';
});

//Router Guarantor
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/guarantor.php';
});

//Router Company
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/company.php';
});

//Router Marketing
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/maketting.php';
});

//Router Api
Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/api_web.php';
});

Route::group(array('prefix' => 'manager', 'before' => ''), function () {
    require __DIR__.'/api.php';
});


//Router Ajax
Route::group(array('prefix' => 'ajax', 'before' => ''), function () {
    Route::post('upload', array('as' => 'ajax.upload','uses' => 'AjaxUploadController@upload'));
});

Route::get('sentmail/mail',array('as' => 'admin.mail','uses' => 'MailSendController@sentEmail'));

