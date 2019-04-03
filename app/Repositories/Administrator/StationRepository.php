<?php

namespace App\Repositories\Administrator;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Rinvex\Repository\Exceptions\RepositoryException;
use App\Entities\Administrator\Station;
use DB;

class StationRepository extends AppBaseRepository implements RepositoriesContract
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
     */

    public function findRelationship(int $stationId) : Station
    {
        try {
            return $this->createModel()->with(['originalState', 'filterState', 'typeStation'])->find($stationId);
        } catch (RepositoryException $e) { /** TODO */ dd('Error al optener la estacion y sus relaciones');}
    }


    /**
     * @param int $id
     * @return Station
     */
    public function getTypeStation(int $id) : Station
    {
        dd($this->queryBuilder()
            ->select('station_type.*')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station.id',$id)->get());
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


    /**
     * @param int $stationId
     * @return Station
     */
    public function getIdNetForIdStation(int $stationId) : Station
    {
        return $this->select('net_id as id')->where('id',$stationId)->first();
    }

    /**
     * @param int $netId
     * @return Collection
     */
    public function getAllStationForNet(int $netId) : Collection
    {
        return $this->queryBuilder()->select('id','name')->where('net_id','=',$netId)->orderby('name','ASC')->get();
    }

    /**
     *
     * @param $netId
     * @return \Illuminate\Support\Collection
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
    public function countMissingDataForStation(string $fact_table, int $station_id) : array /** TODO ESTE METODO NO DEBE ESTAR ACA */
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

    /**
     * @param int $net
     * @param string $etlMethod
     * @return array
     */
    public function getStationsId(int $net,string $etlMethod) : array
    {
        return $this->queryBuilder()
            ->select('station.id')
            ->where('station.net_id',$net)
            ->join('station_type', 'station_type.id', '=', 'station.station_type_id')
            ->where('station_type.etl_method',$etlMethod)
            ->pluck('station.id')
            ->toArray();
    }

    /**
     * @param int $station
     * @return string
     */
    public function getStationId(int $station) : string
    {
        return $this->queryBuilder()
            ->select('station_type.etl_method')
            ->where('station.id',$station)
            ->join('station_type', 'station_type.id', '=', 'station.station_type_id')
            ->pluck('station_type.etl_method')
            ->toArray()[0];
    }

    public function countReportData($station)
    {

    }

    /**
     * @return Collection
     */

    public function listStations() : Collection
    {
        return $this->select('*')->where('active','=',true)->where('rt_active','=',true)->get();
    }

    /**
     * @param int $station_id
     * @return array
     */

    public function getStationDate($station_id) : array
    {
        return $this->select('station.id','station.name','station.measurements_per_day')
            ->where('station.name','=',$station_id)
            ->where('station.etl_active',true)
            ->orderby('station.name','ASC')
            ->get()
            ->toArray();
    }

    /**
     * @param int $netId
     * @return array
     */
    public function getStationForNetAuditoryActive($netId) : array
    {
        return $this->select('station.id','station.net_id','station.table_db_name','station.station_type_id','station.name')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station.net_id',$netId)
            ->where('station.active',true)
            ->whereNotNull('station_type.etl_method')
            ->get()
            ->toArray();
    }
    /**
     * @return Collection
     */
    public function getStationAuditoryActive() : Collection
    {
        return $this->select('station.id','station.table_db_name','station.station_type_id','station.name')
            ->join('station_type','station.station_type_id','=', 'station_type.id')
            ->where('station.station_type_id','<=',2)
            ->where('station.active',true)
            ->whereNotNull('station_type.etl_method')
            ->get();
    }

    /**
     * @param string $etlMethod
     * @return array
     */
    public function getStationToOriginalMethod(string $etlMethod) : array
    {
        return $this->queryBuilder()
            ->select('station.id')
            ->join('original_state','station.id','=','original_state.station_id')
            ->join('station_type','station.station_type_id','=','station_type.id')
            ->where('original_state.updated','=',false)
            ->where('station.etl_active','=',true)
            ->where('station_type.etl_method','=',$etlMethod)
            ->get()
            ->toArray();
    }
    /**
     * @param string $etlMethod
     * @return array
     */
    public function getStationToFilterMethod(string $etlMethod) : array
    {
        return $this->queryBuilder()
            ->select('station.id')
            ->join('filter_state','station.id','=','filter_state.station_id')
            ->join('station_type','station.station_type_id','=','station_type.id')
            ->where('original_state.updated','=',false)
            ->where('station.etl_active','=',true)
            ->where('station_type.etl_method','=',$etlMethod)
            ->get()
            ->toArray();
    }
}