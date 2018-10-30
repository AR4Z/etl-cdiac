<?php
/**
 * Created by PhpStorm.
 * User: Mayordan
 * Date: 30/05/2018
 * Time: 9:06 PM
 */

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class LevelAlert extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'level_alert';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'alert_id','name','code','description','level','maximum','minimum'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alert() : BelongsTo
    {
        return $this->belongsTo(Alert::class,'alert_id');
    }
}