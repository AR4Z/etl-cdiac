<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

  public function station()
  {
    return $this->hasOne(
        'App\Entities\Config\Station',
        $this->primaryKey,
        $this->foreignStation
    );
  }

}
