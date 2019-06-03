<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Net extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'net';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'connection_id','name','description','administrator_name', 'center_latitude_degrees','center_latitude_minutes','center_latitude_seconds',
        'center_latitude_direction', 'center_longitude_degrees', 'center_longitude_minutes', 'center_longitude_seconds',
        'center_longitude_direction', 'rt_active', 'etl_active','map_zoom', 'original_updated', 'filtered_updated'
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
        return $this->belongsToMany(Map::class,'net_map','net_id','map_id')
                    ->withPivot(['id','rt_active','rt_default_active'])
                    ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(Station::class,'station_net','net_id','station_id')
            ->withPivot(['id','rt_active'])
            ->withTimestamps();
    }

    /**
     * @return BelongsTo
     */
    public function connection() : BelongsTo
    {
        return $this->belongsTo(Connection::class,'connection_id');
    }



}
