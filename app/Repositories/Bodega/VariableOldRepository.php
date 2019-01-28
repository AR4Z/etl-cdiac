<?php

namespace App\Repositories\Bodega;


use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\Variable;
use DB;

class VariableOldRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

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
    public function getVariable() : Collection
    {
        return $this->select('id_variable','nombre')->get();
    }

    /**
    /**
     * @param int $var
     * @return Collection
     */
    public function getVariableNameById($var) : Collection
    {
        return $this->select('id_variable','nombre')->where('id_variable','=',$var)->get()->toArray();
    }

    /**
     * @param int $station_id
     * @return array
     */
    public function getVariableByStation($station_id) : array
    {
        return $this->select('id_variable','nombre')
            ->join('variables','variables.variables','=', 'variable.nombre')
            ->where('variables.estacion_sk','=', $station_id)
            ->get()
            ->toArray();
    }

    /**
     * @param int $var
     * @return Collection
     */
    public function getVariableNameCentral($var) : Collection
    {
        return $this->select('varible_database')->where('id_variable','=',$var)->get();
    }

    /**
     * @param int $station_id
     * @param string $var
     * @return array
     */
    public function getVarExistByStation($station_id,$var) : array
    {
        return $this->select('id_variable','nombre')
            ->join('variables','variables.variables','=', 'variable.nombre')
            ->where('variables.variables','=',$var)
            ->where('variables.estacion_sk','=', $station_id)
            ->get()
            ->toArray();
    }

}