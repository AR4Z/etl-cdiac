<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
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
  protected $table= 'variable';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id','name', 'name_excel', 'name_database','name_locale'
  ];

  public function stations(){
      return $this->hasMany('App\Entities\Config\VarForStation', 'variable_id');
  }
}
