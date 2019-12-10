<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function xmlTest()
	{


		$xml_str = "<xml>
		<ToUserName><![CDATA[gh_85f26cbaf766]]></ToUserName>
		<FromUserName><![CDATA[ovh231S5UOQ3o5OLx1ETDYFyjqeo]]></FromUserName>
		<CreateTime>1575889456</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[..]]></Content>
		<MsgId>22561312870196269</MsgId>
		</xml>";


		$xml_obj = simplexml_load_string($xml_str);
		echo '<pre>';print_r($xml_obj);echo'</pre>';die;
		echo '<pre>';print_r($xml_obj);echo'</pre>';echo'<hr>';
		
		echo 'ToUserName:'.$xml_obj->ToUserName;echo'<hr>';
		echo 'FromUserName:'.$xml_obj->FromUserName;echo'<hr>';
	}

}
