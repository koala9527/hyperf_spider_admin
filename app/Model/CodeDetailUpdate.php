<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class CodeDetailUpdate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'code_detail_update';


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
    
    public static function getCodeList($spn,$keyword,$page,$page_size,$one_class,$two_class){
        $params = [];
        if (!empty($one_class)) $params[] = ['firstOneTag',$one_class];
        if (!empty($two_class))$params[] = ['secondOneTag', 'like', '%'.$two_class.'%'];
        if (!empty($spn))$params[] = ['spncode', 'like', '%'.$spn.'%'];
        if (!empty($keyword))$params[] = ['pcode', 'like', '%'.$keyword.'%'];
        $list = self::where($params)->orderBy('id', 'desc')->paginate($page_size, ['*'], 'page', $page);
        return $list ? $list->toArray() : [];
    }

    public static function getCodeDetail($id){
        $res =  self::where(['id'=>$id])->get();
        return $res ? $res->toArray() : [];
    }

    public static function getTwoClass($one)
    {
        $res =  self::select("secondOneTag","firstOneTag")->where(['firstOneTag'=>$one])->groupBy('secondOneTag')->get();
        $result=[];
        foreach($res as $k=>$v){
            if(!empty($v['secondOneTag'])){
                if(strpos($v['secondOneTag'],',') !== false){
                    $pieces = explode(",",$v['secondOneTag']);
                    foreach($pieces as $key=>$val){
                        // array_push($result,$val);
                        
                        $result[] = $val;
                    } 
                }else{
                    // array_push($result,$v['secondOneTag']);

                    $result[] = $v['secondOneTag'];
                }
            }
        }
        $result = array_unique($result);
        $all_res=[];
        foreach($result as $ke=>$va){
            $all_res[]=$va;
        }
        return $all_res;
    }

    public static function changeStatus($id)
    {
        $res =  self::where(['id'=>$id])->value("status");
        if($res=='0'){
            $update = '1';
        }else{
            $update = '0';
        }
        self::where(['id'=>$id])->update(['status' => $update]);
    }
}