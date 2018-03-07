<?php

namespace App\Repositories\DataWareHouse;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\GroundwaterFact;

class GroundwaterFactRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = GroundwaterFact::class;

}