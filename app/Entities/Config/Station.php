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
     * @return HasMany
     */
    public function connection() : HasMany
    {
        return $this->hasMany(Connection::class, $this->primaryKey, $this->foreignConnection);
    }

    /**
     * @return HasMany
     */

    public function varForStation() : HasMany
    {
        return $this->hasMany(VarForStation::class, $this->primaryKey);
    }

    /**
     * @return BelongsTo
     */
    public function originalState() : BelongsTo
    {
        return $this->belongsTo(OriginalState::class, $this->primaryKey);
    }

    /**
     * @return BelongsTo
     */

    public function filterState() : BelongsTo
    {
        return $this->belongsTo(FilterState::class, $this->primaryKey);
    }
}
