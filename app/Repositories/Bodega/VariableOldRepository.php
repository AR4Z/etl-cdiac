<?php

namespace App\Repositories\Bodega;


use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\Variable;
use DB;



class VariableOldRepository extends EloquentRepository implements RepositoriesContract
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

    // Auditory System Functions

    /**
     * @return object
     */
    public function getVariable()
    {
        return $this
            ->select('id_variable','nombre')
            ->get();
    }

    /**
    /**
     * @param int $var
     * @return array
     */
    public function getVariableNameById($var)
    {
        return $this
            ->select('id_variable','nombre')
            ->where('id_variable','=',$var)
            ->get()->toArray();
    }
    /**
     * @param int $station_id
     * @return array
     */
    public function getVariableByStation($station_id)
    {
        return $this
            ->select('id_variable','nombre')
            ->join('variables','variables.variables','=', 'variable.nombre')
            ->where('variables.estacion_sk','=', $station_id)
            ->get()->toArray();
    }
    /**
     * @param int $var
     * @return object
     */
    public function getVariableNameCentral($var)
    {
        return $this
            ->select('varible_database')
            ->where('id_variable','=',$var)
            ->get();
    }
    /**
     * @param int $station_id
     * @param string $var
     * @return array
     */
    public function getVarExistByStation($station_id,$var)
    {
        return $this
            ->select('id_variable','nombre')
            ->join('variables','variables.variables','=', 'variable.nombre')
            ->where('variables.variables','=',$var)
            ->where('variables.estacion_sk','=', $station_id)
            ->get()->toArray();
    }

}