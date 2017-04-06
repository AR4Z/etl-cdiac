<?php


namespace App\Repositories\DataWareHouse;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\OriginalFactTable;

class OriginalFactTableRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = OriginalFactTable::class;
}