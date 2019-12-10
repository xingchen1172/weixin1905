<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table="test";
    
    public $primaryKey='t_id';  
    /** 
     * 可以被批量赋值的属性
     */
     protected $fillable = ['t_name','t_desc','t_class'];
     /**打上时间戳 */
     public $timestamps = false;
}
