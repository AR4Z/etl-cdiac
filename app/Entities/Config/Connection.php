<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stations() : BelongsTo
    {
      return $this->belongsTo('App\Entities\Config\Station', 'connection_id');
  }
}
