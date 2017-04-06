<?php


namespace App\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\OriginalFactAir;

class OriginalFactAirRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = OriginalFactAir::class;
}