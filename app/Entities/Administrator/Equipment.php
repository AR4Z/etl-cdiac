<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'equipment';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'equipment_category_id','name','description'
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
    public function equipmentCategory() : BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class,'equipment_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maintenances() : HasMany
    {
        return $this->hasMany(EquipmentMaintenance::class,'equipment_id','id');
    }
}
