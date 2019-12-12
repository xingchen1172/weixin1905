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
        // $log_file = "wx.log";
        //将接收到的文件记录到日志文件
        // $xml_str = file_get_contents("php://input");
        // $data = date('Y-m-d H:i:s').$xml_str;
        // file_put_contents($log_file,$data,FILE_APPEND);
// 
// 
        //处理xml数据
        // $xml_obj = simplexml_load_string($xml_str);
// 
// 
        //获取事件类型
        // $event = $xml_obj->Event;
        // if($event=='subscribe'){
            //获取用户的openid
            // $openid=$xml_obj->FromUserName;
            // $user_data = [
            //   'openid' =>  $openid,
            //   'sub_time'  => $xml_obj->CreateTime,
            // ];
// 
            // $uid = WxUser::insertGetId($user_data);
            // var_dump($uid);
            // die;
// 
           // 获取用户信息
            // $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$openid.'&lang=zh_CN';
            // $user_info = file_get_contents($url);
            // file_put_contents('wx_user.log',$user_info,FILE_APPEND);
        // }

        //将接收到的苏剧记录到日志文件
        $log_file="wx.log";
        $xml_str= file_get_contents("php://input");
        $data=date("Y-m-d h:i:s").$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);


        //处理xml数据
        $xml_obj=simplexml_load_string($xml_str);
        $event=$xml_obj->Event;
        if($event=='subscribe'){
            $openid=$xml_obj->FromUserName;//获取用户的openid


            $res=P_wx_users::where('openid',$openid)->first();
            $msg='欢迎回来';
            if($res){
                $xml='<xml>
              <ToUserName><![CDATA['.$openid.']]></ToUserName>
              <FromUserName><![CDATA['.$xml_obj->ToUserName.']]></FromUserName>
              <CreateTime>'.time().'</CreateTime>
              <MsgType><![CDATA[text]]></MsgType>
              <Content><![CDATA['.$msg.']]></Content>
            </xml>';
                echo $xml;
            }else{
                //获取用户信息
                $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid=' .$openid;
                $user_info=file_get_contents($url);
                $user=json_decode($user_info,true);//转换为数组
//                dump($user);
                file_put_contents('wx_user.log',$user_info,FILE_APPEND);


                $data=[
                    'openid'=>$openid,
                    'subscribe_time'=>$user['subscribe_time'],
                    'nickname'=>$user['nickname'],
                    'sex'=>$user['sex'],
                    'headimgurl'=>$user['headimgurl']


                ];
                $res=P_wx_users::create($data);
                $msg='谢谢关注';
                $xml='<xml>
  <ToUserName><![CDATA['.$openid.']]></ToUserName>
  <FromUserName><![CDATA['.$xml_obj->ToUserName.']]></FromUserName>
  <CreateTime>'.time().'</CreateTime>
  <MsgType><![CDATA[text]]></MsgType>
  <Content><![CDATA['.$msg.']]></Content>
</xml>';
                echo $xml;
            }
        }
        $msg_type=$xml_obj->MsgType;
        $touser = $xml_obj->FromUserName;
        $fromuser=$xml_obj->TouserName;
        $time=time();
        if($msg_type=="text"){
            $content=date('Y-m-d h:i:s').$xml_obj->Content;
            $response_text='<xml>
                <ToUserName><![CDATA['.$touser.']]></ToUserName>
                <FromUserName><![CDATA['.$fromuser.']]></FromUserName>
                <CreateTime>'.$time.'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$content.']]></Content>
               </xml>';
            echo $response_text;
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



