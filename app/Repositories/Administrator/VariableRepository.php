<?php

namespace App\Repositories\Administrator;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Administrator\Variable;
use Illuminate\Support\Collection;

class VariableRepository extends AppBaseRepository implements RepositoriesContract
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
     * @return Collection
     */
    public function getVariableName() : Collection
    {
        return $this->select('id','name')->get();
    }

    /**
     * @param int $station_id
     * @return Collection
     */
    public function getVariableNameByStation($station_id) : Collection
    {
        return $this->select('name')->where('id',$station_id)->get();
    }

    /**
     * @param string $var
     * @return Collection
     */
    public function getVariableNameByVarOldDataWarehouse($var) : Collection
    {
        return $this->select('id','name')->where('excel_name',$var)->get();
    }

    /**
     * @param int $station
     * @param int $var
     * @return array
     */
    public function getVariableInformation($station,$var) : array
    {
        return $this->select('*')
            ->join('variable_station','variable_station.variable_id','=','variable.id')
            ->where('variable.id',$var)
            ->where('variable_station.station_id',$station)
            ->whereNotNull('maximum')
            ->whereNotNull('minimum')
            ->get()
            ->toArray();
    }
}