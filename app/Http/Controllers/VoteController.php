<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(){
        // echo __METHOD__;
        echo '<pre>';print_r($_GET);echo'</pre>';
    }
}
