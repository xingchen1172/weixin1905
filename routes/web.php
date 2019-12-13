<?php

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
    return view('welcome');
});

Route::get('info',function(){
	phpInfo();
});



// Route::get('/GetuserInfo','Weixin\WxController@GetuserInfo');//微信方法


/*微信开发*/
Route::get('/wx/test','Weixin\WxController@test');
Route::get('/wx','Weixin\WxController@wxchat'); 
Route::get('/wx/media','Weixin\WxController@getMedia');//获取临时素材

/*接收用户的推送事件*/
Route::post('/wx','Weixin\WxController@receiv');



Route::get('/test/xml','Test\TestController@xmlTest');

