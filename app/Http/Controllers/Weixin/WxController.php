<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUser;

class WxController extends Controller
{
      protected $access_token;


      public function __construct(){
        //获取access_token
        $this->access_token=$this->getAccessToken();
      }




      protected function getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET');
        $data_json = file_get_contents($url);
        $arr = json_decode($data_json,true);
        return $arr['access_token'];
      }



     public function wxchat(){ 
        $token='2259b56f5898cd6192c50';  //开发提前设置好的token

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr = $_GET["echostr"];

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $echostr;
        }else{
            die("not ok");
        }
  }


     /*接收微信推送事件*/
    public function receiv(){
        $log_file = "wx.log";
        //将接收到的文件记录到日志文件
        $data = json_encode($_POST);
        file_put_contents($log_file,$data,FILE_APPEND);


        
      }


    /*获取用户基本信息*/
    public function getUserInfo($access_token,$openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';


        // //发送网络请求
        // $json_str = file_get_contents($url);
        // $log_file = 'wx_user.log';
        // file_put_contents($log_file,$json_str,FILE_APPEND);
    }
}

