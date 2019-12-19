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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('info',function(){
	phpInfo();
});


Route::any('/','Index\IndexController@index');   //网站首页



// Route::get('/GetuserInfo','Weixin\WxController@GetuserInfo');//微信方法


/*微信开发*/
Route::any('/wx/test','Weixin\WxController@test');   //woyebzdws
Route::any('/wx','Weixin\WxController@wxchat'); 
Route::any('/wx/media','Weixin\WxController@getMedia');//获取临时素材


/*接收用户的推送事件*/
Route::any('/wx','Weixin\WxController@receiv');

Route::get('/wx/flush/access_token','Weixin\WxController@flushAccessToken');        //刷新access_token
Route::get('/wx/menu','Weixin\WxController@createMenu');        //创建菜单


Route::get('/vote','VoteController@index');        //微信投票
Route::get('/dev/redis/del','VoteController@delkey');        //微信投票


Route::any('/test/xml','Test\TestController@xmlTest');

