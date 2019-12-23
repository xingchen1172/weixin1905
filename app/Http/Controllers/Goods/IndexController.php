<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;

class IndexController extends Controller
{
    public function index(Request $request){
        $goods_id = $request->input('id');
        $goods = Goods::find($goods_id);
        // echo '<pre>';print_r($goods);echo '</pre>';
        $data = [
            'goods'     => $goods
        ];
        return view('goods/index',$data);
    }
} 
