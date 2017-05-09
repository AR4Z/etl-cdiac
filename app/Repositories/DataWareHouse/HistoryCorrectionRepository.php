<?php

namespace App\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\HistoryCorrection;

class HistoryCorrectionRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = HistoryCorrection::class;
}