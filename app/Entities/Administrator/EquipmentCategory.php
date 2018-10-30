<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentCategory extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'equipment_category';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments() : HasMany
    {
        return $this->hasMany(EquipmentCategory::class,'equipment_category_id');
    }
}
