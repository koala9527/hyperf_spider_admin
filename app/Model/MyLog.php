<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $log_type 
 * @property string $key 
 * @property string $val1 
 * @property string $val2 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class MyLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_log';
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
    protected $casts = ['id' => 'int', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public static function save_data($id,$text)
    {
        $data = self::where(
            ['log_type' => '1', 'key' => $id,'val1'=>$text]
        )->exists();
        
        if(!$data){
            self::insert(['log_type' => '1', 'key' => $id,'val1'=>$text]);
        };
        return "已记录";
    }
}