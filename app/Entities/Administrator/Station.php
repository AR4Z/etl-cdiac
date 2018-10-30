<?php

namespace App\Entities\Administrator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Station extends Model
{
    /**
     * @var string
     */
    protected $connection = 'administrator';

    /**
     * @var string
     */
    protected $table = 'station';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id','station_type_id','net_id','code','name','description','table_db_name','measurements_per_day','active',
        'rt_active','etl_active','community','start_operation','finish_operation','latitude_degrees','latitude_minutes',
        'latitude_seconds','latitude_direction','longitude_degrees','longitude_minutes','longitude_seconds','longitude_direction',
        'city','localization','basin','sub_basin','image_1','image_2','pdf_file','comment'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nets() : BelongsToMany
    {
        return $this->belongsToMany(Net::class,'station_net','station_id','net_id')
            ->withPivot(['id','rt_active'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function net() : BelongsTo
    {
        return $this->belongsTo(Net::class,'net_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeStation() : BelongsTo
    {
        return $this->belongsTo(StationType::class,'station_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function technicalSheetFields() : BelongsToMany
    {
        return $this->belongsToMany(TechnicalSheetField::class,'technical_sheet_field_station','station_id', 'technical_sheet_field_id')
                    ->withPivot(['id','rt_active','value'])
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variables() : BelongsToMany
    {
        return $this->belongsToMany(Variable::class,'variable_station','station_id','variable_id')
                    ->withPivot(['id','maximum','minimum','previous_deference','correction_type','rt_active','etl_active','comment'])
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function graphs() : BelongsToMany
    {
        return $this->belongsToMany(Graph::class,'graph_station','station_id','graph_id')
                    ->withPivot(['id','rt_active'])
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maintenances() : HasMany
    {
        return $this->hasMany(Maintenance::class,'station_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalState() : HasOne
    {
        return $this->hasOne(OriginalState::class,'station_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function filterState() : HasOne
    {
        return $this->hasOne(FilterState::class,'station_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alerts() : BelongsToMany
    {
        return $this->belongsToMany(Alert::class,'alert_station','station_id','alert_id')
            ->withPivot(['id','active','flag_level_one','flag_level_two','flag_level_three'])
            ->withTimestamps();

    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owners() : BelongsToMany
    {
        return $this->belongsToMany(Owner::class,'owner_station','station_id','owner_id')
            ->withPivot(['id'])
            ->withTimestamps();
    }
}
