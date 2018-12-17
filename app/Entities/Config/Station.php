<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
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
    protected $table= 'station';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'connection_id', 'name', 'name_table', 'active', 'type', 'quantity_measurement_day'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $foreignConnection = 'connection_id';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function connection() : HasMany
    {
        return $this->hasMany(
            'App\Entities\Config\Connection',
            $this->primaryKey,
            $this->foreignConnection
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function varForStation() : HasMany
    {
        return $this->hasMany(
            'App\Entities\Config\VarForStation',
            $this->primaryKey
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function originalState() : BelongsTo
    {
        return $this->belongsTo(
            'App\Entities\Config\OriginalState',
            $this->primaryKey
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function filterState() : BelongsTo
    {
        return $this->belongsTo(
            'App\Entities\Config\FilterState',
            $this->primaryKey
        );
    }
}
