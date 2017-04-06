<?php

namespace App\Repositories\DataWareHouse;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\FactAir;

class FactAirRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = FactAir::class;
}