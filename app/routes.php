<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


//User authenticationa and registration routes
Route::get('install',['as'=>'get.setup','uses'=>'HomeController@launchSetup']);
Route::post('install',['as'=>'post.setup','uses'=>'HomeController@saveSetup']);
Route::get('login',['as'=>'get.login','uses'=>'UsersController@getLoginForm']);
Route::post('login',['as'=>'post.login','uses'=>'UsersController@postLogin']);
Route::get('register',['as'=>'get.register','uses'=>'UsersController@getRegistrationForm']);
Route::post('register',['as'=>'post.register','uses'=>'UsersController@postRegister']);
Route::get('security/{activationCode}/activate',['as'=>'activate.user','uses'=>'UsersController@activate'] );
Route::get('security/change',['as'=>'get.change.password','uses'=>'UsersController@getChangePassword'] );
Route::post('security/change',['as'=>'post.change.password','uses'=>'UsersController@changePassword'] );
Route::any('logout',['as'=>'logout','uses'=>'UsersController@logout']);


//must be authenticated to access these routes
Route::group(['before'=>'auth'],function(){
	Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
	Route::get('/dashboard',['as'=>'dashboard','uses'=>'HomeController@index']);
	Route::group(['prefix'=>'account'],function(){
		Route::get('users',['as'=>'list.users','uses'=>'UsersController@getUsersList']);
		Route::get('add',['as'=>'get.add.user','uses'=>'UsersController@getAddAccount']);
		Route::post('add',['as'=>'add.user','uses'=>'UsersController@postAddAccount']);
		Route::get('profile',['as'=>'my.profile','uses'=>'UsersController@showMyProfile']);
		Route::get('{id}/profile',['as'=>'view.profile','uses'=>'UsersController@showUserProfile']);
	});
	Route::group(['prefix'=>'businesses'],function(){
		Route::get('',['as'=>'list.businesses','uses'=>'BusinessController@index']);
		Route::get('add',['as'=>'get.add.business','uses'=>'BusinessController@getAddBusiness']);
		Route::post('add',['as'=>'add.business','uses'=>'BusinessController@postAddBusiness']);
		Route::get('{id}/show',['as'=>'view.biz','uses'=>'BusinessController@showBusiness']);
	});

	Route::group(['prefix'=>'services'],function(){
		Route::get('',['as'=>'list.departments','uses'=>'ServicesController@index']);
		Route::get('{id}/list',['as'=>'list.services','uses'=>'ServicesController@getServices']);
		Route::get('apply',['as'=>'get.apply.service','uses'=>'ServicesController@getApplyForm']);
		Route::get('houserent',['as'=>'get.houserent','uses'=>'ServicesController@getHouserent']);
		Route::get('stalls',['as'=>'get.stalls','uses'=>'ServicesController@getStalls']);
		Route::post('stalls',['as'=>'fetch.stalls','uses'=>'ServicesController@fetchStalls']);
		Route::get('landrates',['as'=>'get.landrates','uses'=>'ServicesController@getLandrates']);
		Route::post('apply',['as'=>'post.apply.service','uses'=>'ServicesController@postApplyForm']);
		Route::post('search_land',['as'=>'search.land','uses'=>'ServicesController@searchLand']);
		Route::post('search_housing',['as'=>'search.housing','uses'=>'ServicesController@searchHousing']);
	});

	Route::group(['prefix'=>'applications'],function(){
		Route::get('',['as'=>'my.applications','uses'=>'HomeController@showApplications']);
		Route::get('current',['as'=>'approved.applications','uses'=>'HomeController@approvedApplications']);
	});

	Route::group(['prefix'=>'bills'],function(){
		Route::get('',['as'=>'my.bills','uses'=>'HomeController@showBills']);
		Route::get('{id}/invoice',['as'=>'my.invoice','uses'=>'HomeController@showInvoice']);
	});

	Route::group(['prefix'=>'land'],function(){
		Route::get('registration',['as'=>'land.register','uses'=>'LandController@register']);
		Route::post('registration',['as'=>'land.submit.registration','uses'=>'LandController@submitRegistration']);
	});


	//ajax table actions
	Route::group(['prefix'=>'api'],function()
	{
		Route::get('users',['as'=>'list.users.ajax','uses'=>'AjaxController@getUsers']);
		Route::get('biz',['as'=>'list.businesses.ajax','uses'=>'AjaxController@getBusinesses']);
		Route::get('apps',['as'=>'list.applications.ajax','uses'=>'AjaxController@getApplications']);
		Route::get('current',['as'=>'list.approved_applications.ajax','uses'=>'AjaxController@approvedApplications']);
		Route::get('bills',['as'=>'list.bills.ajax','uses'=>'AjaxController@getInvoices']);
		Route::get('invoice/{id}/pay',['as'=>'pay.invoice','uses'=>'PaymentController@getPaymentStatus']);
		Route::any('estate/house',['as'=>'get.houses','uses'=>'ServicesController@fetchEstateHouses']);
		Route::any('subcounty/wards',['as'=>'get.wards','uses'=>'ServicesController@fetchWards']);
		Route::any('',['as'=>'update','uses'=>'ServicesController@update']);
	});
});
