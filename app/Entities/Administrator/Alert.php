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
     * @var string
     */
    protected $foreignKey = 'alert_id';

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
     * @var array
     */
    protected $pivotStation = [
        'table'         => 'station',
        'pivotTable'    => 'alert_station',
        'foreignKey'    => 'station_id',
        'variables'     => ['id','active','flag_level_one','flag_level_two','flag_level_three']
    ];

    /**
     * @return BelongsToMany
     */
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(Station::class,$this->pivotStation['pivotTable'],$this->foreignKey,$this->pivotStation['foreignKey'])->withPivot($this->pivotStation['variables'])->withTimestamps();
    }

    /**
     * @return HasOne
     */
    public function originalState() : HasOne
    {
        return $this->hasOne(LevelAlert::class,$this->foreignKey,$this->primaryKey);
    }


}