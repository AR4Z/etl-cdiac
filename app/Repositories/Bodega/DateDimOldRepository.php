<?php

namespace App\Repositories\Bodega;


use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Bodega\DateDim;

class DateDimOldRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(DateDim::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param $date
     * @return Collection
     */
    public function getDate($date) : Collection
    {
        return $this->select('fecha_sk')->where('fecha','=',$date)->get();
    }
}