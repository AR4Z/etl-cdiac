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
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $foreignStation = 'station_id';

    /**
     * @var
     */
    public $completeDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','station_id', 'current_date', 'current_time','it_update'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return Carbon
     */
    public function getFullDateAttribute() : Carbon
    {
        return Carbon::parse($this->current_date. ' '. $this->current_time);
    }

    /**
     * @return HasOne
     */
    public function station() : HasOne
    {
        return $this->hasOne(Station::class, $this->primaryKey, $this->foreignStation);
    }
}
