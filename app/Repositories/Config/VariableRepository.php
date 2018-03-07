<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Variable;
/**
 *
 */
class VariableRepository extends EloquentRepository
{
  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = Variable::class;


}
