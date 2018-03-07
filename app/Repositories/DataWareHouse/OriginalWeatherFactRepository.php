<?php

namespace App\Repositories\DataWareHouse;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\OriginalWeatherFact;

class OriginalWeatherFactRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = OriginalWeatherFact::class;

}