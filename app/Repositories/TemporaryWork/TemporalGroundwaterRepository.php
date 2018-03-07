<?php

namespace App\Repositories\TemporaryWork;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\TemporalGroundwater;

class TemporalGroundwaterRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';
    protected $model = TemporalGroundwater::class;
}