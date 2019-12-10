<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxController extends Controller
{
     public function wxchat(){
         $token = 'asdfghjkl654';
         $signature = $_GET["signature"];
         $timestamp = $_GET["timestamp"];
         $nonce = $_GET["nonce"];
         $echostr = $_GET["echostr"];

         $tmpArr =array($token,$timestamp,$nonce);
         sort($tmpArr,SORT_STRING);
         $tmpstr = implode($tmpstr);
         if($tmpstr == $signature){
             echo $echostr;
         }else{
             die("not ok");
         }
     }
     public function GetuserInfo(){

        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';
     }
}
