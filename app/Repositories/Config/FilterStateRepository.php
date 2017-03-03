<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\FilterState;
/**
 *
 */
class FilterStateRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = FilterState::class;
}
