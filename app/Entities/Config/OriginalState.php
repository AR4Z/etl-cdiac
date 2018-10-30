<?php

namespace App\Entities\Config;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OriginalState extends Model
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
    protected $table= 'original_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','station_id', 'current_date', 'current_time','it_update'
    ];

    protected $dates = [

    ];

    protected $primaryKey = 'id';

    protected $foreignStation = 'station_id';

    public $completeDate;

    /**
     * @return Carbon
     */
    public function getFullDateAttribute() : Carbon
    {

        return Carbon::parse($this->current_date. ' '. $this->current_time);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
