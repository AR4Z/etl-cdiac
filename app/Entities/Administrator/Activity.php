<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'activity';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $foreignKey = 'activity_id';

    /**
     * @var array
     */
    protected $fillable = [
        'name','description'
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
     * @var array
     */
    protected $pivotEquipmentMaintenance = [
        'table'         => 'equipment_maintenance',
        'pivotTable'    => 'activity_equipment_maintenance',
        'foreignKey'    => 'equipment_maintenance_id',
        'variables'     => []
    ];

    /**
     * @return BelongsToMany
     */
    public function activityEquipmentMaintenances() : BelongsToMany
    {
        return $this->belongsToMany(EquipmentMaintenance::class,$this->pivotEquipmentMaintenance['pivotTable'],$this->foreignKey,$this->pivotEquipmentMaintenance['foreignKey'])->withTimestamps();
    }
}
