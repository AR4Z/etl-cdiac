<?php

namespace App\Repositories\Bodega;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\FactTable;

class FactTableRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(FactTable::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param $station
     * @return Collection
     */
    public function CountFactTableData($station) : Collection
    {
        return $this->selectRaw('count(estacion_sk) AS count')->where('estacion_sk','=',$station)->get();
    }

    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function CountNegativeRisk($station_id,$var,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->where($var, '<', 0 )
            ->whereBetween('fecha_sk',[$date1,$date2])
            ->get()
            ->toArray();

    }
    /**
     * @param int $station_id
     * @param string $var
     * @param float $range1
     * @param float $range2
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function countFactInOfRange($station_id,$var,$range1,$range2,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereBetween('fecha_sk',[$date1,$date2])
            ->whereBetween($var, [$range1,$range2])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param float $range1
     * @param float $range2
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function countFactOutOfRange($station_id,$var,$range1,$range2,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereBetween('fecha_sk',[$date1,$date2])
            ->whereNotBetween($var, [$range1,$range2])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function NotExistVarForStation($station_id,$var,$date1,$date2) : Collection
    {
       return $this->select('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->where($var,'>',0)
            ->whereBetween('date_dim.fecha',[$date1,$date2])
            ->join('date_dim','fact_table.fecha_sk','=','date_dim.fecha_sk')
            ->get();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return Collection
     */
    public function ConsecutiveErrors($station_id,$var,$date1,$date2) : Collection
    {
       return $this->select($var)
            ->where('estacion_sk','=',$station_id)
            ->whereBetween('date_dime.fecha',[$date1,$date2])
            ->join('date_dim','fact_table.fecha','=','date_dim.fecha')
            ->get();
    }


    /**
     * @param int $station
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function getAverage($station,$var,$date1,$date2) : array
    {
        return $this->selectRaw("avg($var)")
            ->where('estacion_sk','=',$station)
            ->whereNotNull($var)
            ->where($var,'>',0)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()->toArray();
    }
    /**
     * @param int $station
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function getDeviation($station,$var,$date1,$date2) : array
    {
        return $this->selectRaw("stddev($var)")
            ->where('estacion_sk','=',$station)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()
            ->toArray();
    }

    /**
     * @param int $station
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @param $date_start
     * @param $date_end
     * @return array
     */
    public function getOutlier($station,$var,$date1,$date2,$date_start,$date_end) : array
    {
        return $this->select('estacion_sk',$var,'date_dim.año')
            ->join('date_dim','date_dim.fecha_sk','=', 'fact_table.fecha_sk')
            ->where('estacion_sk','=',$station)
            ->whereNotNull($var)
            ->whereBetween($var,[$date1,$date2])
            ->whereBetween('fact_table.fecha_sk',[$date_start,$date_end])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function getDates($station,$var,$date1,$date2) : array
    {
        return $this->select('estacion_sk','fecha_sk',$var)
            ->where('estacion_sk','=',$station)
            ->whereNotNull($var)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()->toArray();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function receiveDataWithNullData($station_id,$var,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function receiveData($station_id,$var,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereNotNull($var)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function CountNullData($station_id,$var,$date1,$date2) : array
    { return $this->selectRaw('count(estacion_sk)')
        ->where('estacion_sk','=',$station_id)
        ->where($var, '=', null )
        ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
        ->get()
        ->toArray();
    }
    /**
     * @param int $station_id
     * @param int $var
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function evapotranspirationRisk($station_id,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereNotnull('evapotranspiracion')
            ->where('temperatura','=',null)
            ->where('humedad_relativa','=',null)
            ->where('radiacion_solar','=',null)
            ->where('presion_barometrica','=',null)
            ->where('velocidad_viento','=',null)
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->get()
            ->toArray();
    }
    /**
     * @param int $station_id
     * @param date $date1
     * @param date $date2
     * @return array
     */
    public function evapotranspirationNullRisk($station_id,$date1,$date2) : array
    {
        return $this->selectRaw('count(estacion_sk)')
            ->where('estacion_sk','=',$station_id)
            ->whereNull('evapotranspiracion')
            ->whereBetween('fact_table.fecha_sk',[$date1,$date2])
            ->where(function ($query) use ($station_id){
                $query->OrWhere('temperatura','!=',null)
                    ->OrWhere('humedad_relativa','!=',null)
                    ->OrWhere('radiacion_solar','!=',null)
                    ->OrWhere('presion_barometrica','!=',null)
                    ->OrWhere('velocidad_viento','!=',null)
                    ->GroupBy('estacion_sk');
            })
            ->get()
            ->toArray();
    }
}