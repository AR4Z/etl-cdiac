<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\VarForStation;
/**
 *
 */
class VarForStationRepository extends EloquentRepository
{
  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = VarForStation::class;
}
