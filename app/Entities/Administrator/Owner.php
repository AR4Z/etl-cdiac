<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Owner extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'owner';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'name','code','description'
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
        return $this->belongsToMany(Station::class,'owner_station','owner_id','station_id')
            ->withPivot(['id'])
            ->withTimestamps();
    }
}