<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\InformationRequest;
use App\Repositories\AppGeneralRepositoryBaseTrait;

class InformationRequestRepository extends  EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(InformationRequest::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}