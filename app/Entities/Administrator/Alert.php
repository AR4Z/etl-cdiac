<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alert extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'alert';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'name','code','description','active'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(Station::class,'alert_station','alert_id','station_id')
            ->withPivot(['id','active','flag_level_one','flag_level_two','flag_level_three'])
            ->withTimestamps();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalState() : HasOne
    {
        return $this->hasOne(LevelAlert::class,'alert_id','id');
    }


}