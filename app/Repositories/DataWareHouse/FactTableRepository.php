<?php


namespace app\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\FactTable;

class FactTableRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = FactTable::class;
}