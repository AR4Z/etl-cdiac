<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maintenance extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'maintenance';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'station_id','scheduled_date','maintenance_date','state','comment','maintenance_type','creation_date'
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
        'created_at', 'updated_at','creation_date','maintenance_date','scheduled_date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station() : BelongsTo
    {
        return $this->belongsTo(Station::class,'station_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments() : HasMany
    {
        return $this->hasMany(EquipmentMaintenance::class,'maintenance_id','id');
    }
}
