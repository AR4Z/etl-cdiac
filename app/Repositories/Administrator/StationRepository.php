<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Station;
use DB;

class StationRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * StationRepository constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Station::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder() : Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }

    /**
     * @return mixed
     */
    public function getEtlActive() : Collection
    {
        return $this->select('*')->where('etl_active', true)->get();
    }

    /**
     * @param int $stationId
     * @return Station
     */
    public function getStation(int $stationId) : Station
    {
        return $this->select('*')->where('id',$stationId)->first();
    }

    /**
     * @param int $stationId
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */

    public function findRelationship(int $stationId) : Station
    {
        return $this->createModel()->with(['originalState','filterState','typeStation'])->find($stationId);
    }


    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|Builder|null|object
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getTypeStation(int $id)
    {
        return $this->queryBuilder()
                    ->select('station_type.*')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->where('station.id',$id)
                    ->first();
    }

    /**
     * @param int $stationId
     * @return Collection
     */
    public function findVarForFilter(int $stationId) : Collection
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
                'variable.reliability_name',
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


    /**
     * @return Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationInServerAcquisition() : Collection
    {
        return $this->queryBuilder()
                    ->select('station.id','station.name','original_state.current_date','original_state.current_time')
                    ->where('station.etl_active', true)
                    ->join('original_state','original_state.station_id','=','station.id')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->where('station_type.etl_method', '=', 'weather')
                    ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationsForFilterETL() : Collection
    {
        return $this->queryBuilder()
                    ->select('station.id','station.name','station.net_id','filter_state.current_date','filter_state.current_time')
                    ->join('filter_state','station.id','=', 'filter_state.station_id')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->whereNotNull('station_type.etl_method')
                    ->where('station.etl_active',true)
                    ->where('filter_state.updated',false)
                    ->whereNotNull('station.table_db_name')
                    ->orderby('station.id','ASC')
                    //->limit(1)
                    ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationsForOriginalETL() : Collection
    {
        return $this->queryBuilder()
                    ->select('station.id','station.name','station.net_id','original_state.current_date','original_state.current_time')
                    ->join('original_state','station.id','=', 'original_state.station_id')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->whereNotNull('station_type.etl_method')
                    ->where('station.etl_active',true)
                    ->where('original_state.updated',false)
                    ->whereNotNull('station.table_db_name')
                    ->orderby('station.id','ASC')
                    //->limit(1)
                    ->get();

    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationEtlActive() : Collection
    {
        return $this->queryBuilder()
                    ->select('station.id', 'station.name')
                    ->join('net','station.net_id','=','net.id')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->whereNotNull('station_type.etl_method')
                    ->where('station.etl_active',true)
                    ->where('net.etl_active',true)
                    ->orderby('station.name','ASC')
                    ->get();
    }

    /**
     * @return Collection
     */
    public function getStationsForEtl() : Collection
    {
        return $this->select('id','net_id')->where('etl_active',true)->get();
    }

    //Auditory System Functions

    /**
     * @param int $stationId
     * @return Station
     */
    public function getIdNetForIdStation(int $stationId) : Station
    {
        return $this->select('net_id as id')->where('id',$stationId)->first();
    }

    /**
     *
     * @param $netId
     * @return \Illuminate\Support\Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationForNetEtlActive($netId) : Collection
    {
        return $this->queryBuilder()
                    ->select('station.id','station.net_id','station.station_type_id','station.name')
                    ->join('station_type','station.station_type_id','=', 'station_type.id')
                    ->where('station.net_id',$netId)
                    ->whereNotNull('station_type.etl_method')
                    ->get();
    }

    /**
     * @param $type
     * @return \Illuminate\Support\Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getStationsForTypology(string $type) : Collection
    {
        return $this->queryBuilder()
            ->select('station.id as id','station.name as name')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station_type.etl_method',$type)
            ->orderby('name','ASC')
            ->get();
    }

    /**
     * @param string $type
     * @return array
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getIdStationsForTypology(string $type) : array
    {
        return $this->queryBuilder()
                ->select('station.id')
                ->join('station_type','station.station_type_id','=', 'station_type.id')
                ->where('station_type.etl_method',$type)
                ->pluck('id')
                ->toArray();
    }

    /**
     * @param string $fact_table
     * @param int $station_id
     * @return array
     */
    public function countMissingDataForStation(string $fact_table, int $station_id) : array
    {
        return DB::connection('data_warehouse')
                    ->table($fact_table)
                    ->select(DB::raw("station_dim.station_sk, station_dim.name, date_dim.date_sk, date_dim.date, count($fact_table.time_sk)"))
                    ->where("$fact_table.station_sk", '=',$station_id)
                    ->join('station_dim', $fact_table.'.station_sk', '=', 'station_dim.station_sk')
                    ->join('date_dim', $fact_table.'.date_sk', '=', 'date_dim.date_sk')
                    ->groupBy("station_dim.station_sk", "station_dim.name", "date_dim.date_sk", "date_dim.date")
                    ->orderBY('date_dim.date_sk')
                    ->get()
                    ->toArray();
    }

    public function countReportData($station)
    {

    }

    //APP map

    /**
     * @return object
     */

    public function listStations() : Collection
    {
        return $this->select('*')->where('active','=',true)->where('rt_active','=',true)->get();
    }

    // Auditory System Functions

    /**
     * @param int $station_id
     * @return array
     */

    public function getStationDate($station_id)
    {
        return $this->select('station.id','station.name','station.measurements_per_day')
            ->where('station.name','=',$station_id)
            ->where('station.etl_active',true)
            ->orderby('station.name','ASC')
            ->get()->toArray();
    }

    /**
     * @param int $netId
     * @return array
     */
    public function getStationForNetAuditoryActive($netId)
    {
        return $this->select('station.id','station.net_id','station.table_db_name','station.station_type_id','station.name')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station.net_id',$netId)
            ->where('station.active',true)
            ->whereNotNull('station_type.etl_method')
            ->get()->toArray();
    }
    /**
     * @return object
     */
    public function getStationAuditoryActive()
    {
        return $this->select('station.id','station.table_db_name','station.station_type_id','station.name')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station.station_type_id','<=',2)
            ->where('station.active',true)
            ->whereNotNull('station_type.etl_method')
            ->get();
    }
}