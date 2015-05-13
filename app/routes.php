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
Route::group(['prefix' => 'v1'], function() {
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

	Route::get('demo', ['as' => 'baringo.demo', 'uses' => 'DemoController@baringo']);

	Route::group(['before'=>'auth'],function(){
		Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
		Route::get('/dash',['as'=>'dash','uses'=>'HomeController@index']);
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

});

# refactory
Route::group([], function() {
	Route::get('login',['as'=>'portal.login','uses'=> 'AuthenticationController@login']);
	Route::get('logout', ['as' => 'portal.logout', 'uses' => 'AuthenticationController@logout']);
	Route::post('login', ['as' => 'portal.post.login', 'uses' => 'AuthenticationController@postLogin']);
	Route::get('register', ['as' => 'portal.get.register', 'uses' => 'AuthenticationController@getRegister']);
	Route::post('register', ['as'=>'portal.post.register', 'uses' => 'AuthenticationController@postRegister']);


	Route::group(['before'=>'auth'],function(){
		Route::get('/', ['as' => 'portal.home', 'uses' => 'DashboardController@home']);
		Route::get('account', ['as' => 'portal.account', 'uses' => 'SettingsController@account']);
		# dashboard menu
		Route::get('home', ['as' => 'portal.home', 'uses' => 'DashboardController@home']);
		Route::get('manage', ['as' => 'portal.manage', 'uses' => 'DashboardController@manage']);
		Route::get('support', ['as' => 'portal.support', 'uses' => 'DashboardController@support']);
		Route::get('dashboard', ['as' => 'portal.dashboard', 'uses' => 'DashboardController@home']);
		Route::get('services', ['as' => 'portal.services', 'uses' => 'DashboardController@services']);
		Route::get('settings', ['as' => 'portal.settings', 'uses' => 'DashboardController@settings']);

		# land rates services
		Route::group(['prefix' => 'land'], function() {
			Route::get('pay', ['as' => 'land.pay', 'uses' => 'LandController@pay']);
			Route::get('', ['as' => 'land.services', 'uses' => 'LandController@services']);
			Route::get('search', ['as' => 'land.search', 'uses' => 'LandController@search']);
			Route::get('invoice/{id}', ['as' => 'land.invoice', 'uses' => 'LandController@invoice']);
			Route::get('register', ['as' => 'land.registration', 'uses' => 'LandController@register']);
			Route::post('search', ['as' => 'land.post.search', 'uses' => 'LandController@submitSearch']);
			Route::post('register', ['as' => 'land.submit.registration', 'uses' => 'LandController@submitRegistration']);
		});

		# signage services
		Route::group(['prefix' => 'signage'], function() {
			Route::get('apply', ['as' => 'signage.apply', 'uses' => 'SignageController@apply']);
			Route::get('', ['as' => 'signage.services', 'uses'  =>  'SignageController@services']);
			Route::get('charges', ['as' => 'signage.charges', 'uses' => 'SignageController@charges']);
			Route::get('applications', ['as' => 'signage.applications', 'uses' => 'SignageController@applications']);
			Route::post('application', ['as' => 'signage.submit.application', 'uses' => 'SignageController@submitApplication']);
		});

		# building services
		Route::group(['prefix' => 'building'], function() {
			Route::get('', ['as' => 'building.services', 'uses'  =>  'BuildingController@services']);
			Route::get('fencing', ['as' => 'building.fencing', 'uses' => 'BuildingController@fencing']);
			Route::get('approval', ['as' => 'building.approval', 'uses' => 'BuildingController@approval']);
			Route::get('occupation', ['as' => 'building.occupation', 'uses' => 'BuildingController@occupation']);
			Route::post('approval', ['as' => 'building.submit.approval', 'uses' => 'BuildingController@submitApproval']);
		});

		# housing services
		Route::group(['prefix' => 'housing'], function() {
			Route::get('home', ['as' => 'housing.home', 'uses' => 'HousingController@home']);
			Route::get('stall', ['as' => 'housing.stall', 'uses' => 'HousingController@stall']);
			Route::get('', ['as' => 'housing.services', 'uses'  =>  'HousingController@services']);
			Route::get('applications', ['as' => 'housing.applications', 'uses' => 'HousingController@applications']);
			Route::get('occupation', ['as' => 'building.occupation', 'uses' => 'BuildingController@occupation']);
			Route::post('approval', ['as' => 'building.submit.approval', 'uses' => 'BuildingController@submitApproval']);
		});

		# settings
		Route::group(['prefix' => 'settings'], function() {
			Route::get('', ['as' => 'settings.services', 'uses' => 'SettingsController@services']);
			Route::get('account', ['as' => 'settings.account', 'uses' => 'SettingsController@account']);
		});

		# hire
		Route::group(['prefix' => 'hire'], function() {
			Route::get('', ['as' => 'hire.services', 'uses' => 'HireController@services']);
			Route::get('stadia', ['as' => 'hire.stadia', 'uses' => 'HireController@stadia']);
			Route::post('stadium', ['as' => 'hire.stadium', 'uses' => 'HireController@stadium']);
			Route::post('premise', ['as' => 'hire.premise', 'uses' => 'HireController@premise']);
			Route::post('article', ['as' => 'hire.article', 'uses' => 'HireController@article']);
			Route::get('premises', ['as' => 'hire.premises', 'uses' => 'HireController@premises']);
			Route::post('purposes', ['as' => 'hire.purposes', 'uses' => 'HireController@purposes']);
			Route::get('equipment', ['as' => 'hire.equipment', 'uses' => 'HireController@equipment']);
		});

		# permits
		Route::group(['prefix' => 'permits'], function() {
			Route::get('', ['as' => 'permits.services', 'uses' => 'PermitsController@services']);
			Route::get('apply', ['as' => 'permits.apply', 'uses' => 'PermitsController@apply']);
			Route::get('renew', ['as' => 'permits.renew', 'uses' => 'PermitsController@renew']);
			Route::post('application', ['as' => 'permits.submit.application', 'uses' => 'PermitsController@submitApplication']);
		});

		# weights
		Route::group(['prefix' => 'weights'], function() {
			Route::get('', ['as' => 'weights.services', 'uses' => 'WeightsController@services']);
			Route::get('apply', ['as' => 'weights.apply', 'uses' => 'WeightsController@apply']);
			Route::get('renew', ['as' => 'weights.renew', 'uses' => 'WeightsController@renew']);
			Route::post('application', ['as' => 'weights.submit.application', 'uses' => 'WeightsController@submitApplication']);
		});

		Route::group(['prefix' => 'lease'], function() {
			Route::get('', ['as' => 'request.lease.contract', 'uses' => 'LeaseController@requestContract']);
			Route::post('', ['as' => 'submit.lease.contract', 'uses' => 'LeaseController@submitContract']);
		});

	});


});


//must be authenticated to access these routes
