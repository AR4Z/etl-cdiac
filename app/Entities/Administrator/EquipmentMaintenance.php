<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EquipmentMaintenance extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'equipment_maintenance';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'maintenance_id', 'equipment_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
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
    public function maintenance() : BelongsTo
    {
        return $this->belongsTo(Maintenance::class,'maintenance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment() : BelongsTo
    {
        return $this->belongsTo(Equipment::class,'equipment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activities() : BelongsToMany
    {
        return $this->belongsToMany(Activity::class,'activity_equipment_maintenance','activity_id','equipment_maintenance_id')
                    ->withTimestamps();
    }

}
