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

# refactory
Route::group(['prefix' => 'portal'], function() {
	Route::get('/', ['as' => 'portal.login', 'uses' => 'AuthenticationController@login']);

	Route::get('register', ['as' => 'portal.get.register', 'uses' => 'AuthenticationController@getRegister']);
	Route::post('login', ['as' => 'portal.post.login', 'uses' => 'AuthenticationController@postLogin']);

	Route::get('logout', ['as' => 'portal.logout', 'uses' => 'AuthenticationController@logout']);

	Route::get('profile', ['as' => 'portal.profile', 'uses' => 'AuthenticationController@x']);

	# dashboard menu
	Route::get('home', ['as' => 'portal.home', 'uses' => 'DashboardController@home']);
	Route::get('manage', ['as' => 'portal.manage', 'uses' => 'DashboardController@manage']);
	Route::get('support', ['as' => 'portal.support', 'uses' => 'DashboardController@support']);
	Route::get('dashboard', ['as' => 'portal.dashboard', 'uses' => 'DashboardController@home']);
	Route::get('services', ['as' => 'portal.services', 'uses' => 'DashboardController@services']);
	Route::get('settings', ['as' => 'portal.settings', 'uses' => 'DashboardController@settings']);

	Route::group(['prefix' => 'land'], function() {
		Route::get('', ['as' => 'land.services', 'uses' => 'LandController@services']);
		Route::get('invoice', ['as' => 'land.invoice', 'uses' => 'LandController@invoice']);

		Route::get('search', ['as' => 'land.search', 'uses' => 'LandController@search']);
		Route::post('search', ['as' => 'land.post.search', 'uses' => 'LandController@submitSearch']);

		Route::get('register', ['as' => 'land.registration', 'uses' => 'LandController@register']);
		Route::post('register', ['as' => 'land.submit.registration', 'uses' => 'LandController@submitRegistration']);
	});


	Route::group(['prefix' => 'lease'], function() {
		Route::get('', ['as' => 'request.lease.contract', 'uses' => 'LeaseController@requestContract']);
		Route::post('', ['as' => 'submit.lease.contract', 'uses' => 'LeaseController@submitContract']);
	});

	Route::group(['prefix' => 'sbp'], function() {
		Route::get('', ['as' => 'request.sbp.service', 'uses' => 'SbpController@requestService']);
		Route::post('', ['as' => 'submit.sbp.request', 'uses' => 'LeaseController@submitRequest']);
	});
});


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

	Route::group(['prefix'=>'rentals'],function(){
		Route::get('',['as'=>'rental','uses'=>'StallsController@index']);
		Route::get('stalls',['as'=>'stall.registration','uses'=>'StallsController@register']);
		Route::post('stalls',['as'=>'stall.submit.registration','uses'=>'StallsController@submitRegistration']);
	});

	Route::group(['prefix' => 'zones'], function(){
		Route::get('list', ['as' => 'zones_list', 'uses' => 'ZonesController@getList' ]);
		Route::get('', ['as' => 'zones', 'uses' => 'AuthenticationController@index' ]);
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
