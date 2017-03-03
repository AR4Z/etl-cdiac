<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
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
  protected $table= 'external_connection';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id','name', 'driver', 'host','port','database','username', 'password', 'active', 'filtered'
  ];

  public function stations(){
      return $this->belongsTo('App\Entities\Config\Station', 'connection_id');
  }
}
