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


     /*接收微信推送事件*/
    public function receiv(){
        $log_file = "wx.log";
        //将接收到的文件记录到日志文件
        $xml_str = file_get_contents("php://input");
        $data = date('Y-m-d H:i:s').$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);


        //处理xml数据
        $xml_obj = simplexml_load_string($xml_str);


        //获取事件类型
        $event = $xml_obj->Event;
        if($event=='subscribe'){
            //获取用户的openid
            $openid=$xml_obj->FromUserName;
            //获取用户信息
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$openid.'&lang=zh_CN';
            $user_info = file_get_contents($url);
            file_put_contents('wx_user.log',$user_info,FILE_APPEND);
        }
      }


    /*获取用户基本信息*/
    public function getUserInfo($access_token,$openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';


        //发送网络请求
        $json_str = file_get_contents($url);
        $log_file = 'wx_user.log';
        file_put_contents($log_file,$json_str,FILE_APPEND);
    }
}

