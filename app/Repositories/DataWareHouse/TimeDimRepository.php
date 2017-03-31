<?php
/**
 * Created by PhpStorm.
 * User: Mayordan
 * Date: 31/03/2017
 * Time: 2:53 PM
 */

namespace app\Repositories\DataWareHouse;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\TimeDim;

class TimeDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TimeDim::class;


    public function getTimeSk($time){
        return $this->select('tiempo_sk')
                    ->where('tiempo','=',$time)
                    ->first()
                    ->tiempo_sk;
    }
}