<?php


namespace App\Repositories\Administrator;

use App\Entities\Administrator\AlertLandslide;
use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;

class AlertLandslideRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(AlertLandslide::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}