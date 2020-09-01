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
    
    public static function getCodeList($keyword,$page,$page_size,$one_class,$two_class){
        $list = self::where('title', 'like', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate($page_size, ['*'], 'page', $page);
        return $list ? $list->toArray() : [];
    }
}