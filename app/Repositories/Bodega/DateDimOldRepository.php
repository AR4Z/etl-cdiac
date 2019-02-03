<?php

namespace App\Repositories\Bodega;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Entities\Bodega\DateDim;

class DateDimOldRepository extends AppBaseRepository implements RepositoriesContract
{
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