<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Variable;
use DB;

class VariableRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Variable::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }

    //Auditory System Functions
    /**
     * @return object
     */
    public function getVariableName()
    {
        return $this->select('id','name')->get();

    }
    /**
     * @param int $station_id
     * @return object
     */
    public function getVariableNameByStation($station_id)
    {
        return $this
            ->select('name')
            ->where('id',$station_id)
            ->get();

    }
    /**
     * @param string $var
     * @return object
     */
    public function getVariableNameByVarOldDataWarehouse($var)
    {
        return $this
            ->select('id','name')
            ->where('excel_name',$var)
            ->get();

    }
    /**
     * @param int $station
     * @param int $var
     * @return array
     */
    public function getVariableInformation($station,$var)
    {
        return $this
            ->select('*')
            ->join('variable_station','variable_station.variable_id','=','variable.id')
            ->where('variable.id','=',$var)
            ->where('variable_station.station_id',$station)
            ->whereNotNull('maximum')
            ->whereNotNull('minimum')
            ->get()->toArray();
    }
    /**
     * @param string $netId
     * @return object
     */


}