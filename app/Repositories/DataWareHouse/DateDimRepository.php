<?php


namespace app\Repositories\DataWareHouse;


use Carbon\Carbon;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\DateDim;

class DateDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = DateDim::class;


    /**
     * @param Carbon $date
     * @return mixed
     */
    public function getDateSk(Carbon $date)
    {
        return $this->select('fecha_sk')
                    ->whereDay('fecha', '=', $date->day)
                    ->whereMonth('fecha', '=', $date->month)
                    ->whereYear('fecha', '=', $date->year)
                    ->first()
                    ->fecha_sk;
    }
}