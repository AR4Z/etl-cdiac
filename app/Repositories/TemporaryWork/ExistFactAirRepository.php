<?php

namespace App\Repositories\TemporaryWork;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\ExistFactAir;

class ExistFactAirRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';
    protected $model = ExistFactAir::class;
}