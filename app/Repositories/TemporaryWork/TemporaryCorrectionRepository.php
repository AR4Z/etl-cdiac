<?php


namespace App\Repositories\TemporaryWork;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\TemporaryWork\TemporaryCorrection;

class TemporaryCorrectionRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(TemporaryCorrection::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}