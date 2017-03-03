<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\OriginalState;
/**
 *
 */
class OriginalStateRepository extends EloquentRepository
{
  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = OriginalState::class;
}
