<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\DataQuality;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;
use App\Entities\Auditory\Auditory;

/**
 *
 */
class DataQualityRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = DataQuality::class;

    protected function queryBuilder()
    {
        return DB::connection('administrator')->table('station');
    }

    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getName($connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }

    public function getDescription($connectionName)
    {
        return $this->where('description', $connectionName)->first();
    }

    public function getDataQualityName()
    {
        return DB::connection('auditory')
            ->table('data_quality')
            ->select('data_quality.id','data_quality.name')
            ->orderby('data_quality.id','ASC')
            //->limit(1)
            ->get();

    }

    public function getDataQualityById($id)
    {
        return DB::connection('auditory')
            ->table('data_quality')
            ->select('data_quality.id')
            ->where('data_quality.id',$id)
            //->limit(1)
            ->get();

    }


}