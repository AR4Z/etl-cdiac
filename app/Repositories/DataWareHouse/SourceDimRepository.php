<?php

namespace App\Repositories\DataWareHouse;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\SourceDim;

class SourceDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = SourceDim::class;

}