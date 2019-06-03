<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TechnicalSheetField extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'technical_sheet_field';

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
     * @return BelongsToMany
     */
    public function stations() : BelongsToMany
    {
        return $this->belongsToMany(Station::class,'technical_sheet_field_station','station_id','technical_sheet_field_id')
                    ->withPivot(['id','rt_active','value'])
                    ->withTimestamps();
    }
}
