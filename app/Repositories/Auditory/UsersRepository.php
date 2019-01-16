<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\Users;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class UsersRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = Users::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getIdRed($connectionName)
    {
        return $this->where('Id_red', $connectionName)->first();
    }

    public function getName($connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }

    public function getRol($connectionName)
    {
        return $this->where('rol', $connectionName)->first();
    }

    public function getEMail($connectionName)
    {
        return $this->where('e_mail', $connectionName)->first();
    }

    public function getMinimumRange($connectionName)
    {
        return $this->where('minimum_range', $connectionName)->first();
    }

    public function getPaswword($connectionName)
    {
        return $this->where('password', $connectionName)->first();
    }


}
