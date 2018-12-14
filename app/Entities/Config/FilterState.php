<?php

namespace App\Entities\Config;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed current_time
 * @property mixed current_date
 */
class FilterState extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'config';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table= 'filter_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','station_id', 'current_date', 'current_time','it_update'
    ];

    protected $primaryKey = 'id';

    protected $foreignStation = 'station_id';

    protected $dates = [

    ];

    /**
     * @return Carbon
     */
    public function getFullDateAttribute() : Carbon
    {
        return Carbon::parse($this->current_date. ' '. $this->current_time);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function station() : HasOne
    {
        return $this->hasOne(
            'App\Entities\Config\Station',
            $this->primaryKey,
            $this->foreignStation
        );
    }

}
