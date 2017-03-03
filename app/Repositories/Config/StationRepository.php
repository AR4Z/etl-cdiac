<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Station;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class StationRepository extends EloquentRepository
{
  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = Station::class;

    /**
     * @param $stationId
     * @return mixed
     */

    public function findRelationship(int $stationId)
    {
      return $this->createModel()
                    ->with(
                        [
                            'originalState',
                            'filterState',
                            'varForStation',
                            'varForStation.variable'
                        ])
                    ->find($stationId);
    }


    /**
     * @param $stationId
     */
    public function findVarForFilter($stationId)
    {
        return DB::connection('config')
                    ->table('variable')
                    ->select('variable.*','var_for_station.*')
                    ->where('var_for_station.station_id',  $stationId)
                    ->join('var_for_station', 'variable.id', '=', 'var_for_station.variable_id')
                    ->get();
    }


}
