<?php

namespace App\Repositories\Administrator;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Connection;


class ConnectionRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = Connection::class;

    public function getStationsNotIn($variables)
    {
        return $this->select('*')->whereNotIn('id',$variables)->get();
    }
}