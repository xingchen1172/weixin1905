<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxController extends Controller
{
     public function wxchat(){
        $token='2259b56f5898cd6192c50';
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr=$_GET['echostr'];
        
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if($tmpStr == $signature){
          echo $echostr;
        }else{
           die('not ok');
        }
     }
     public function GetuserInfo(){

        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';
     }
}
