<?php

namespace App\Repositories\TemporaryWork;

use App\Entities\TemporaryWork\TemporalWeather;
use DB;
use Rinvex\Repository\Repositories\EloquentRepository;


class TemporalWeatherRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = TemporalWeather::class;

    /**
     * @param $data
     * @return bool
     */
    public function insert($data){
        foreach ($data as $row){

            $this->createModel()->create($row);
            dd($row);
        }
        return true;
    }

}
