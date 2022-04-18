<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
// Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'Editor'], function () {
	Route::get('/', ['as' => 'editor.index', 'uses' => 'EditorController@index']);
});



//User Management
Route::group(['prefix' => 'editor', 'middleware' => 'auth', 'namespace' => 'Editor'], function () {



	// Route::get('/dudu', 'PengeluaranController@index');
	//Home
	Route::get('/', ['as' => 'editor.index', 'uses' => 'EditorController@index']);
	//Notif
	Route::get('/notif', ['as' => 'editor.notif.index', 'uses' => 'EditorController@notif']);
	//Profile
	//detail
	Route::get('/profile', ['as' => 'editor.profile.show', 'uses' => 'ProfileController@show']);
	//edit
	Route::get('/profile/edit', ['as' => 'editor.profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('/profile/edit', ['as' => 'editor.profile.update', 'uses' => 'ProfileController@update']);
	//edit password
	Route::get('/profile/password', ['as' => 'editor.profile.edit_password', 'uses' => 'ProfileController@edit_password']);
	Route::put('/profile/password', ['as' => 'editor.profile.update_password', 'uses' => 'ProfileController@update_password']);

	// // telegram
	Route::get('/send-telegram-message/{notifiable}', ['as' => 'editor.send-telegram-message.index', 'uses' => 'TelegramController@index']);

	Route::PUT('/send-telegram-message/{notifiable}', ['as' => 'editor.send-telegram-message.update', 'uses' => 'TelegramController@send_message']);

	//index
	Route::get('/user', ['middleware' => ['role:user|read'], 'as' => 'editor.user.index', 'uses' => 'UserController@index']);
	//create
	Route::get('/user/create', ['middleware' => ['role:user|create'], 'as' => 'editor.user.create', 'uses' => 'UserController@create']);
	Route::post('/user/create', ['middleware' => ['role:user|create'], 'as' => 'editor.user.store', 'uses' => 'UserController@store']);
	//edit
	Route::get('/user/{id}/edit', ['middleware' => ['role:user|update'], 'as' => 'editor.user.edit', 'uses' => 'UserController@edit']);
	Route::put('/user/{id}/edit', ['middleware' => ['role:user|update'], 'as' => 'editor.user.update', 'uses' => 'UserController@update']);
	//delete
	Route::delete('/user/delete/{id}', ['middleware' => ['role:user|delete'], 'as' => 'editor.user.delete', 'uses' => 'UserController@delete']);

	//User
	//index
	Route::get('/userbranch', ['middleware' => ['role:userbranch|read'], 'as' => 'editor.userbranch.index', 'uses' => 'UserbranchController@index']);
	//create
	Route::get('/userbranch/create', ['middleware' => ['role:userbranch|create'], 'as' => 'editor.userbranch.create', 'uses' => 'UserbranchController@create']);
	Route::post('/userbranch/create', ['middleware' => ['role:userbranch|create'], 'as' => 'editor.userbranch.store', 'uses' => 'UserbranchController@store']);
	//edit
	Route::get('/userbranch/{id}/edit', ['middleware' => ['role:userbranch|update'], 'as' => 'editor.userbranch.edit', 'uses' => 'UserbranchController@edit']);
	Route::put('/userbranch/{id}/edit', ['middleware' => ['role:userbranch|update'], 'as' => 'editor.userbranch.update', 'uses' => 'UserbranchController@update']);
	//delete
	Route::delete('/userbranch/{id}/delete', ['middleware' => ['role:userbranch|delete'], 'as' => 'editor.userbranch.delete', 'uses' => 'UserbranchController@delete']);

	//Module
	//index
	Route::get('/module', ['as' => 'editor.module.index', 'uses' => 'ModuleController@index']);
	//create
	Route::get('/module/create', ['as' => 'editor.module.create', 'uses' => 'ModuleController@create']);
	Route::post('/module/create', ['as' => 'editor.module.store', 'uses' => 'ModuleController@store']);
	//edit
	Route::get('/module/{id}/edit', ['as' => 'editor.module.edit', 'uses' => 'ModuleController@edit']);
	Route::put('/module/{id}/edit', ['as' => 'editor.module.update', 'uses' => 'ModuleController@update']);
	//delete
	Route::delete('/module/{id}/delete', ['as' => 'editor.module.delete', 'uses' => 'ModuleController@delete']);
	//delete
	Route::delete('/module/delete/{id}', ['as' => 'editor.module.delete', 'uses' => 'ModuleController@delete']);

	//Action
	//index
	Route::get('/action', ['as' => 'editor.action.index', 'uses' => 'ActionController@index']);
	//create
	Route::get('/action/create', ['as' => 'editor.action.create', 'uses' => 'ActionController@create']);
	Route::post('/action/create', ['as' => 'editor.action.store', 'uses' => 'ActionController@store']);
	//edit
	Route::get('/action/{id}/edit', ['as' => 'editor.action.edit', 'uses' => 'ActionController@edit']);
	Route::put('/action/{id}/edit', ['as' => 'editor.action.update', 'uses' => 'ActionController@update']);
	//delete
	Route::delete('/action/delete/{id}', ['as' => 'editor.action.delete', 'uses' => 'ActionController@delete']);

	//Privilege
	//index
	Route::get('/privilege', ['as' => 'editor.privilege.index', 'uses' => 'PrivilegeController@index']);
	//create
	Route::get('/privilege/create', ['as' => 'editor.privilege.create', 'uses' => 'PrivilegeController@create']);
	Route::post('/privilege/create', ['as' => 'editor.privilege.store', 'uses' => 'PrivilegeController@store']);
	//edit
	Route::get('/privilege/{id}/edit', ['as' => 'editor.privilege.edit', 'uses' => 'PrivilegeController@edit']);
	Route::put('/privilege/{id}/edit', ['as' => 'editor.privilege.update', 'uses' => 'PrivilegeController@update']);
	//delete
	Route::delete('/privilege/{id}/delete', ['as' => 'editor.privilege.delete', 'uses' => 'PrivilegeController@delete']);


	//Preference
	//index
	Route::get('/preference', ['as' => 'editor.preference.index', 'uses' => 'PreferenceController@index']);
	Route::get('/preference/data', ['as' => 'editor.preference.data', 'uses' => 'PreferenceController@data']);
	//create
	Route::get('/preference/create', ['as' => 'editor.preference.create', 'uses' => 'PreferenceController@create']);
	Route::post('/preference/create', ['as' => 'editor.preference.store', 'uses' => 'PreferenceController@store']);
	//edit
	Route::get('/preference/{id}/edit', ['as' => 'editor.preference.edit', 'uses' => 'PreferenceController@edit']);
	Route::put('/preference/{id}/edit', ['as' => 'editor.preference.update', 'uses' => 'PreferenceController@update']);
	//delete
	Route::delete('/preference/delete/{id}', ['as' => 'editor.preference.delete', 'uses' => 'PreferenceController@delete']);
	Route::post('/preference/deletebulk', ['as' => 'editor.preference.deletebulk', 'uses' => 'PreferenceController@deletebulk']);


	//FamilyCard
	//index
	Route::get('/family-card', ['as' => 'editor.family-card.index', 'uses' => 'FamilyCardController@index']);
	Route::get('/family-card/data', ['as' => 'editor.family-card.data', 'uses' => 'FamilyCardController@data']);
	//create
	Route::get('/family-card/create', ['as' => 'editor.family-card.create', 'uses' => 'FamilyCardController@create']);
	Route::post('/family-card/create', ['as' => 'editor.family-card.store', 'uses' => 'FamilyCardController@store']);
	//edit
	Route::get('/family-card/{id}/edit', ['as' => 'editor.family-card.edit', 'uses' => 'FamilyCardController@edit']);
	Route::put('/family-card/{id}/edit', ['as' => 'editor.family-card.update', 'uses' => 'FamilyCardController@update']);
	//delete
	Route::delete('/family-card/delete/{id}', ['as' => 'editor.family-card.delete', 'uses' => 'FamilyCardController@delete']);
	//delete bulk
	Route::post('/family-card/deletebulk', ['as' => 'editor.family-card.deletebulk', 'uses' => 'FamilyCardController@deletebulk']);

	Route::get('/family-card/{id}/member', ['as' => 'editor.family-card.member', 'uses' => 'FamilyCardController@member']);
	Route::get('/family-card/data-member/{id}', ['as' => 'editor.family-card.data-member', 'uses' => 'FamilyCardController@data_member']);
	Route::post('/family-card/store-member/{id}', ['as' => 'editor.family-card.store-member', 'uses' => 'FamilyCardController@store_member']);
	Route::delete('/family-card/delete-member/{id}', ['as' => 'editor.family-card.delete-member', 'uses' => 'FamilyCardController@delete_member']);

	// IPL
	Route::get('/family-card/{id}/ipl', ['as' => 'editor.family-card.ipl', 'uses' => 'FamilyCardController@ipl']);
	Route::put('/family-card/store-ipl/{id}', ['as' => 'editor.family-card.store-ipl', 'uses' => 'FamilyCardController@store_ipl']);

	//House Type
	//index
	Route::get('/house-type', ['as' => 'editor.house-type.index', 'uses' => 'HouseTypeController@index']);
	Route::get('/house-type/data', ['as' => 'editor.house-type.data', 'uses' => 'HouseTypeController@data']);
	//create
	Route::get('/house-type/create', ['as' => 'editor.house-type.create', 'uses' => 'HouseTypeController@create']);
	Route::post('/house-type/create', ['as' => 'editor.house-type.store', 'uses' => 'HouseTypeController@store']);
	//edit
	Route::get('/house-type/edit/{id}', ['as' => 'editor.house-type.edit', 'uses' => 'HouseTypeController@edit']);
	Route::put('/house-type/edit/{id}', ['as' => 'editor.house-type.update', 'uses' => 'HouseTypeController@update']);
	//delete
	Route::delete('/house-type/delete/{id}', ['as' => 'editor.house-type.delete', 'uses' => 'HouseTypeController@delete']);
	Route::post('/house-type/deletebulk', ['as' => 'editor.house-type.deletebulk', 'uses' => 'HouseTypeController@deletebulk']);


	//SMS Template
	//index
	Route::get('/sms-template', ['as' => 'editor.sms-template.index', 'uses' => 'SMSTemplateController@index']);
	Route::get('/sms-template/data', ['as' => 'editor.sms-template.data', 'uses' => 'SMSTemplateController@data']);
	//create
	Route::get('/sms-template/create', ['as' => 'editor.sms-template.create', 'uses' => 'SMSTemplateController@create']);
	Route::post('/sms-template/create', ['as' => 'editor.sms-template.store', 'uses' => 'SMSTemplateController@store']);
	//edit
	Route::get('/sms-template/edit/{id}', ['as' => 'editor.sms-template.edit', 'uses' => 'SMSTemplateController@edit']);
	Route::put('/sms-template/edit/{id}', ['as' => 'editor.sms-template.update', 'uses' => 'SMSTemplateController@update']);
	//delete
	Route::delete('/sms-template/delete/{id}', ['as' => 'editor.sms-template.delete', 'uses' => 'SMSTemplateController@delete']);
	Route::post('/sms-template/deletebulk', ['as' => 'editor.sms-template.deletebulk', 'uses' => 'SMSTemplateController@deletebulk']);

	//RT
	//index
	Route::get('/rt', ['as' => 'editor.rt.index', 'uses' => 'RTController@index']);
	Route::get('/rt/data', ['as' => 'editor.rt.data', 'uses' => 'RTController@data']);
	//create
	Route::get('/rt/create', ['as' => 'editor.rt.create', 'uses' => 'RTController@create']);
	Route::post('/rt/create', ['as' => 'editor.rt.store', 'uses' => 'RTController@store']);
	//edit
	Route::get('/rt/edit/{id}', ['as' => 'editor.rt.edit', 'uses' => 'RTController@edit']);
	Route::put('/rt/edit/{id}', ['as' => 'editor.rt.update', 'uses' => 'RTController@update']);
	//delete
	Route::delete('/rt/delete/{id}', ['as' => 'editor.rt.delete', 'uses' => 'RTController@delete']);
	Route::post('/rt/deletebulk', ['as' => 'editor.rt.deletebulk', 'uses' => 'RTController@deletebulk']);

	//Pengeluaran
	//index
	Route::get('/dudu', ['as' => 'editor.out.index', 'uses' => 'PengeluaranController@index']);

	Route::get('/dudu/data', ['as' => 'editor.out.data', 'uses' => 'PengeluaranController@data']);
	//create
	Route::get('/dudu/create', ['as' => 'editor.out.create', 'uses' => 'PengeluaranController@create']);
	// Route::post('/store', [App\Http\Controllers\PengeluaranController::class, 'store'])->name('store');
	Route::post('/dudu/create', ['as' => 'editor.out.store', 'uses' => 'PengeluaranController@store']);
	//edit
	// Route::get('/out/edit', ['as' => 'editor.out.edit', 'uses' => 'PengeluaranController@edit']);
	// Route::put('/out/{id}/edit', ['as' => 'editor.out.update', 'uses' => 'PengeluaranController@update']);
	Route::get('/dudu/edit/{id}', ['as' => 'editor.out.edit', 'uses' => 'PengeluaranController@edit']);
	Route::put('/dudu/update/{id}', ['as' => 'editor.out.update', 'uses' => 'PengeluaranController@update']);
	//delete
	Route::delete('/dudu/delete/{id}', ['as' => 'editor.out.delete', 'uses' => 'PengeluaranController@delete']);
	Route::post('/dudu/deletebulk', ['as' => 'editor.out.deletebulk', 'uses' => 'PengeluaranController@deletebulk']);

	//Year
	//index
	Route::get('/year', ['as' => 'editor.year.index', 'uses' => 'YearController@index']);
	Route::get('/year/data', ['as' => 'editor.year.data', 'uses' => 'YearController@data']);
	//create
	Route::get('/year/create', ['as' => 'editor.year.create', 'uses' => 'YearController@create']);
	Route::post('/year/create', ['as' => 'editor.year.store', 'uses' => 'YearController@store']);
	//edit
	Route::get('/year/edit/{id}', ['as' => 'editor.year.edit', 'uses' => 'YearController@edit']);
	Route::put('/year/edit/{id}', ['as' => 'editor.year.update', 'uses' => 'YearController@update']);
	//delete
	Route::delete('/year/delete/{id}', ['as' => 'editor.year.delete', 'uses' => 'YearController@delete']);
	Route::post('/year/deletebulk', ['as' => 'editor.year.deletebulk', 'uses' => 'YearController@deletebulk']);

	//PaymentType
	//index
	Route::get('/payment-type', ['as' => 'editor.payment-type.index', 'uses' => 'PaymentTypeController@index']);
	Route::get('/payment-type/data', ['as' => 'editor.payment-type.data', 'uses' => 'PaymentTypeController@data']);
	//create
	Route::get('/payment-type/create', ['as' => 'editor.payment-type.create', 'uses' => 'PaymentTypeController@create']);
	Route::post('/payment-type/create', ['as' => 'editor.payment-type.store', 'uses' => 'PaymentTypeController@store']);
	//edit
	Route::get('/payment-type/edit/{id}', ['as' => 'editor.payment-type.edit', 'uses' => 'PaymentTypeController@edit']);
	Route::put('/payment-type/edit/{id}', ['as' => 'editor.payment-type.update', 'uses' => 'PaymentTypeController@update']);
	//delete
	Route::delete('/payment-type/delete/{id}', ['as' => 'editor.payment-type.delete', 'uses' => 'PaymentTypeController@delete']);
	Route::post('/payment-type/deletebulk', ['as' => 'editor.payment-type.deletebulk', 'uses' => 'PaymentTypeController@deletebulk']);

	//DataIPL
	//index
	Route::get('/data-ipl', ['as' => 'editor.data-ipl.index', 'uses' => 'DataIPLController@index']);
	Route::get('/data-ipl/data', ['as' => 'editor.data-ipl.data', 'uses' => 'DataIPLController@data']);
	//edit
	Route::get('/data-ipl/{id}/edit', ['as' => 'editor.data-ipl.edit', 'uses' => 'DataIPLController@edit']);
	Route::put('/data-ipl/{id}/edit', ['as' => 'editor.data-ipl.update', 'uses' => 'DataIPLController@update']);

	//Edit IPL
	//index
	Route::get('/edit-ipl', ['as' => 'editor.edit-ipl.index', 'uses' => 'EditIPLController@index']);
	Route::get('/edit-ipl/data', ['as' => 'editor.edit-ipl.data', 'uses' => 'EditIPLController@data']);
	//create
	Route::get('/edit-ipl/create', ['as' => 'editor.edit-ipl.create', 'uses' => 'EditIPLController@create']);
	Route::post('/edit-ipl/create', ['as' => 'editor.edit-ipl.store', 'uses' => 'EditIPLController@store']);
	//edit
	Route::get('/edit-ipl/edit/{id}', ['as' => 'editor.edit-ipl.edit', 'uses' => 'EditIPLController@edit']);
	Route::put('/edit-ipl/edit/{id}', ['as' => 'editor.edit-ipl.update', 'uses' => 'EditIPLController@update']);
	//delete
	Route::delete('/edit-ipl/delete/{id}', ['as' => 'editor.edit-ipl.delete', 'uses' => 'EditIPLController@delete']);
	Route::post('/edit-ipl/deletebulk', ['as' => 'editor.edit-ipl.deletebulk', 'uses' => 'EditIPLController@deletebulk']);

	//PaymentInvoice
	//index
	Route::get('/payment-invoice', ['as' => 'editor.payment-invoice.index', 'uses' => 'PaymentInvoiceController@index']);
	Route::get('/payment-invoice/data', ['as' => 'editor.payment-invoice.data', 'uses' => 'PaymentInvoiceController@data']);
	//edit
	Route::get('/payment-invoice/{id}/edit', ['as' => 'editor.payment-invoice.edit', 'uses' => 'PaymentInvoiceController@edit']);
	Route::put('/payment-invoice/{id}/edit', ['as' => 'editor.payment-invoice.update', 'uses' => 'PaymentInvoiceController@update']);
	//print
	Route::get('/payment-invoice/{id}/print', ['as' => 'editor.payment-invoice.print', 'uses' => 'PaymentInvoiceController@print']);

	//Send Message
	//index
	Route::get('/send-message', ['as' => 'editor.send-message.index', 'uses' => 'SendMessageController@index']);
	Route::post('/send-message/store', ['as' => 'editor.send-message.store', 'uses' => 'SendMessageController@store']);

	//SMS Histroy
	//index
	Route::get('/send-message/history', ['as' => 'editor.send-message.history', 'uses' => 'SendMessageController@history']);
	Route::get('/send-message/history/data', ['as' => 'editor.send-message.data', 'uses' => 'SendMessageController@data']);

	//IPL Period
	//index
	Route::get('/ipl-period', ['as' => 'editor.ipl-period.index', 'uses' => 'IPLPeriodController@index']);
	Route::post('/ipl-period/create', ['as' => 'editor.ipl-period.create', 'uses' => 'IPLPeriodController@store']);

	//IPL Arrears
	//index
	Route::get('/data-ipl-arrears', ['as' => 'editor.data-ipl-arrears.index', 'uses' => 'DataIPLArrearsController@index']);
	Route::get('/data-ipl-arrears/data', ['as' => 'editor.data-ipl-arrears.data', 'uses' => 'DataIPLArrearsController@data']);

	//IPL payment
	//index
	Route::get('/data-ipl-payment', ['as' => 'editor.data-ipl-payment.index', 'uses' => 'DataIPLPaymentController@index']);
	Route::get('/data-ipl-payment/data', ['as' => 'editor.data-ipl-payment.data', 'uses' => 'DataIPLPaymentController@data']);

	//MonthlyReport
	//index
	Route::get('/monthly-report', ['as' => 'editor.monthly-report.index', 'uses' => 'MonthlyReportController@index']);
	Route::post('/monthly-report/data', ['as' => 'editor.monthly-report.data', 'uses' => 'MonthlyReportController@data']);

	//Payment and Arrears Report
	//index
	Route::get('/payment-arrears-report', ['as' => 'editor.payment-arrears-report.index', 'uses' => 'PaymentArrearsReportController@index']);
	Route::post('/payment-arrears-report/data', ['as' => 'editor.payment-arrears-report.data', 'uses' => 'PaymentArrearsReportController@data']);

	//IPL Chart
	//index
	Route::get('/ipl-chart', ['as' => 'editor.ipl-chart.index', 'uses' => 'IPLChartController@index']);
	Route::get('/ipl-chart/view', ['as' => 'editor.ipl-chart.view', 'uses' => 'IPLChartController@view']);
});


//api
Route::group(['prefix' => 'api', 'middleware' => 'auth', 'namespace' => 'Editor'], function () {
	Route::get('/user', ['as' => 'api.user.data', 'uses' => 'UserFilterController@dataUser']);
	Route::get('/privilege', ['as' => 'api.privilege.data', 'uses' => 'PrivilegeController@data']);
	Route::get('/userbranch', ['as' => 'editor.userbranch.data', 'uses' => 'UserbranchController@data']);
	Route::get('/module', ['as' => 'editor.module.data', 'uses' => 'ModuleController@data']);
	Route::get('/action', ['as' => 'editor.action.data', 'uses' => 'ActionController@data']);
	//Popup
	Route::get('/popup', ['as' => 'editor.popup.data', 'uses' => 'PopupController@data']);
	Route::get('/check/popup', ['as' => 'editor.popup.checkpopup', 'uses' => 'PopupController@checkPopUp']);

	//userlog
	Route::get('/userlog', ['as' => 'editor.userlog.dataApi', 'uses' => 'UserLogController@dataApi']);
});
