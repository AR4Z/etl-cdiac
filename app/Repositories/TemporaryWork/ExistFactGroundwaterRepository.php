<?php

namespace App\Repositories\TemporaryWork;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\ExistFactGroundwater;

class ExistFactGroundwaterRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';
    protected $model = ExistFactGroundwater::class;
}