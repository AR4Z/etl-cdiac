<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class ConnectionRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = Connection::class;

}
