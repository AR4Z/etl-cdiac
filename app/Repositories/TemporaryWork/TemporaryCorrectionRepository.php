<?php


namespace App\Repositories\TemporaryWork;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporaryCorrection;

class TemporaryCorrectionRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TemporaryCorrection::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}