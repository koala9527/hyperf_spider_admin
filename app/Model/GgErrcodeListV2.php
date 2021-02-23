<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $sn 
 * @property string $systems 
 * @property string $property 
 * @property string $pcode 
 * @property string $descCn 
 * @property string $num 
 * @property string $fcsId 
 * @property string $solrType 
 * @property string $searchFaultCodeVos 
 * @property string $hlFl 
 * @property string $hlFlField 
 * @property string $isNew 
 * @property string $spnFmi 
 * @property string $otherCode 
 * @property string $vehiDirBottomNames 
 * @property string $vehiDirTopNames 
 * @property string $moduleNames 
 * @property string $vehiDirId 
 * @property string $sort 
 * @property string $vehiDirName 
 * @property string $vehiDirParentName 
 * @property string $status 
 */
class GgErrcodeListV2 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gg_errcode_list_v2';
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
    protected $casts = ['id' => 'int'];


    public static function getCodeList($spn,$keyword,$page,$page_size,$one_class,$two_class,$three_class){
        $list = self::orderBy('id', 'desc')->paginate($page_size, ['*'], 'page', $page);
        return $list ? $list->toArray() : [];
    }
}