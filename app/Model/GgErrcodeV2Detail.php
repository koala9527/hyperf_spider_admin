<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $sn 
 * @property string $fcsId 
 * @property int $status 
 * @property string $faultCodeId 
 * @property string $vehiDirId 
 * @property string $proId 
 * @property string $pcode 
 * @property string $descCn 
 * @property string $systems 
 * @property string $property 
 * @property string $model 
 * @property string $faultDesc 
 * @property string $reason 
 * @property string $causePhenomenon 
 * @property string $reportCondition 
 * @property string $clearCodeCondition 
 * @property string $reasonIds 
 * @property string $stepVoList 
 * @property string $circuitsUrl 
 * @property string $crFaultCodeGuideListRespList 
 * @property string $reasonInfoList 
 */
class GgErrcodeV2Detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gg_errcode_v2_detail';
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
    protected $casts = ['id' => 'int', 'status' => 'integer'];
}