<?php
namespace  App\Etl\Loaders;

use App\Etl\Traits\WorkDatabaseTrait;

abstract class LoadBase
{
    use WorkDatabaseTrait;

    public function redirectExisting($repositorySpaceWork,$repositoryDestination,$repositoryExist,$table){

        $values = ($repositorySpaceWork)::all();

        foreach ($values as $value){

            if ($this->evaluateExistence($repositoryDestination,$value)){

                $this->insertExistTable($table,$repositoryExist::fill($value->toArray())->toArray());

                ($repositorySpaceWork)::delete($value->id);
            }

            //insert?????
        }
    }
}