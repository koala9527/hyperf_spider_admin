<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class CodeRe extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'code_res';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public static function getCodeGui($id,$text){
        $res =  self::where(['proId'=>$id,'name'=>$text])->get();
        return $res ? $res: [];
    }
}