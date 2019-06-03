<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variable extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'variable';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'name','description','excel_name','database_field_name','local_name','reliability_name','decimal_precision','unit', 'report_name'
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
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(Station::class,'variable_station','station_id','variable_id')
            ->withPivot(['id','maximum','minimum','previous_deference','correction_type','rt_active','etl_active','comment'])
            ->withTimestamps();
    }
}
