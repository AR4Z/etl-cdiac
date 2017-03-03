<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

class VarForStation extends Model
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
  protected $table= 'var_for_station';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id','station_id', 'variable_id', 'maximum','minimum','correction_type'
  ];

  public function variable(){
      return $this->belongsTo('App\Entities\Config\variable', 'variable_id');
  }

  public function station(){
      return $this->belongsTo('App\Entities\Config\Station', 'station_id');
  }
}
