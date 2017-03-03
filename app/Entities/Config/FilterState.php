<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

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

  protected $date = [
      'current_date', 'current_time'
  ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
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
