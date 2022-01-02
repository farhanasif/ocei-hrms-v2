<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::group(['prefix' => 'generalSettings'], function () {
    Route::get('/',['as' => 'generalSettings.index', 'uses'=>'Setting\GeneralSettingController@index']);
    Route::post('/',['as' => 'generalSettings.store', 'uses'=>'Setting\GeneralSettingController@store']);
    Route::get('/{generalSettings}/edit',['as'=>'generalSettings.edit','uses'=>'Setting\GeneralSettingController@edit']);
    Route::put('/{generalSettings}',['as' => 'generalSettings.update', 'uses'=>'Setting\GeneralSettingController@update']);
    Route::post('printHeadSettings',['as' => 'printHeadSettings.store', 'uses'=>'Setting\GeneralSettingController@printHeadSettingsStore']);
    Route::put('printHeadSettings/{id}',['as' => 'printHeadSettings.update', 'uses'=>'Setting\GeneralSettingController@printHeadSettingsUpdate']);

   /************************* Ip Settings **********************************************/
   Route::get('/ip_setting',['as' => 'ip.setting', 'uses'=>'Setting\GeneralSettingController@ipSetting']);

   Route::get('/add_ip_address',['as' => 'ip.add_ip_address', 'uses'=>'Setting\GeneralSettingController@addNewIp']);

   Route::post('/ip_store',['as' => 'ip.store', 'uses'=>'Setting\GeneralSettingController@ipStore']);

   Route::any('/ip_edit/{id}',['as' => 'ip.edit', 'uses'=>'Setting\GeneralSettingController@editIp']);
   Route::any('/ip_delete/{id}',['as' => 'ip.destroy', 'uses'=>'Setting\GeneralSettingController@deleteIp']);
   Route::any('/ip_status/{id}',['as' => 'ip.status', 'uses'=>'Setting\GeneralSettingController@changeIpStatus']);

   Route::any('/ip_update',['as' => 'ip.update', 'uses'=>'Setting\GeneralSettingController@updateIp']);
    });
 

    // front end setting 
    Route::resource('service', 'Setting\ServicesController');
    // front end settings control
    Route::get('setting-front-page','Setting\FrontSettingController@index')->name('front.setting');
    Route::post('setting-front-page','Setting\FrontSettingController@store')->name('front.setting.submit');
});

