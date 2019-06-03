<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Map extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'map';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'name','description','initial_zoom', 'initial_latitude_degrees','initial_latitude_minutes','initial_latitude_seconds',
        'center_latitude_direction', 'center_longitude_degrees', 'center_longitude_minutes', 'center_longitude_seconds',
        'center_longitude_direction', 'rt_active'
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
     * @return BelongsToMany
     */
    public function maps() : BelongsToMany
    {
        return $this->belongsToMany(Net::class,'net_map','map_id','net_id')
            ->withPivot(['id','rt_active','rt_default_active'])
            ->withTimestamps();
    }
}
