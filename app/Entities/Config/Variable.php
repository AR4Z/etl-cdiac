<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $foreignConnection = 'variable_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'name_excel', 'name_database','name_locale'
    ];


    /**
     * @return HasMany
     */
    public function varForStation() : HasMany
    {
        return $this->hasMany(
            'App\Entities\Config\VarForStation',
            $this->primaryKey
        );
    }
}
