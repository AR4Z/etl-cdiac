<?php

namespace App\Repositories\Administrator;

use DB;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Station;

class StationRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = Station::class;

    protected function queryBuilder()
    {
        return DB::connection('administrator')->table('station');
    }

    public function getEtlActive()
    {
        return $this->select('*')->where('etl_active', true)->get();
    }

    public function getStation($stationId)
    {
        return $this->select('*')->where('id',$stationId)->first();
    }

    /**
     * @param $stationId
     * @return mixed
     */

    public function findRelationship(int $stationId)
    {
        return $this->createModel()->with(['originalState','filterState','typeStation'])->find($stationId);
    }
    /**
     * @param $stationId
     */
    public function findVarForFilter($stationId)
    {
        return DB::connection('administrator')
            ->table('variable')
            ->select(
                'variable_station.id',
                'variable_station.variable_id',
                'variable_station.station_id',
                'variable.name',
                'variable.excel_name',
                'variable.database_field_name',
                'variable.local_name',
                'variable.decimal_precision',
                'variable.unit',
                'variable.correct_serialization',
                'variable_station.maximum',
                'variable_station.minimum',
                'variable_station.previous_deference',
                'variable_station.correction_type',
                'variable.description'
            )
            ->where('variable_station.station_id',  $stationId)
            ->where('variable_station.etl_active', true)
            ->join('variable_station', 'variable.id', '=', 'variable_station.variable_id')
            ->get();
    }

    public function getStationInServerAcquisition()
    {
        return $this->queryBuilder()->select('station.id','station.name','original_state.current_date','original_state.current_time')
                    ->where('station.etl_active', true)
                    ->join('original_state','original_state.station_id','=','station.id')
                    ->get();
    }
}