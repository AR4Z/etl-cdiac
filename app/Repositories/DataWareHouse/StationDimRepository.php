<?php
/**
 * Created by PhpStorm.
 * User: Mayordan
 * Date: 31/03/2017
 * Time: 2:53 PM
 */

namespace app\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\StationDim;

class StationDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = StationDim::class;
}