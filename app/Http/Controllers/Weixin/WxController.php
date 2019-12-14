<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUser;
use Illuminate\Support\Facades\Redis;

class WxController extends Controller
{
      protected $access_token;


      public function __construct(){
        //获取access_token
        $this->access_token=$this->getAccessToken();
      }
      public function test(){
        echo $this->access_token;
      }




      protected function getAccessToken(){

        $key = 'wx_asscess_token';

        $access_token = Redis::get($key);

        // var_dump($access_token);die;
        if($access_token){
          return $access_token;
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET');
          // echo $url;die;
        $data_json = file_get_contents($url);
        $arr = json_decode($data_json,true);


        Redis::set($key,$arr['access_token']);
        Redis::expire($key,3600);
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
        $xml = file_get_contents("php://input");
        $data = date('Y-m-d H:i:s') . $xml;
        file_put_contents($log_file,$data,FILE_APPEND);   //追加写

        //处理xml数据
        $xml_arr = simplexml_load_string($xml_str);

        //入库   其他逻辑


        
      }


    /*获取用户基本信息*/
    public function getUserInfo($access_token,$openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';


        // //发送网络请求
        $json_str = file_get_contents($url);
        $log_file = 'wx_user.log';
        file_put_contents($log_file,$json_str,FILE_APPEND);
    }
}




