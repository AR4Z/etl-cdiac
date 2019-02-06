<?php

namespace App\Etl\Traits;

use App\Repositories\RepositoriesContract;
use Facades\App\Repositories\DataWareHouse\CorrectionHistoryRepository;
use Facades\App\Repositories\TemporaryWork\TemporaryCorrectionRepository;
use App\Etl\Database\Query;
use DB;

trait WorkDatabaseTrait
{
    /**
     * @param string $connection
     * @param string $table
     * @param string $keys
     * @param string $select
     * @param string $initialDate
     * @param string $initialTime
     * @param string $finalDate
     * @param string $finalTime
     * @return mixed
     */
    public function getExternalDataWDT(string $connection, string $table, string $keys, string $select, string $initialDate, string $initialTime, string $finalDate, string $finalTime)
    {
        $query = new Query();

        return $query->init($connection,$table)
                    ->select($select)
                    ->externalWhereBetween($keys,$initialDate,$initialTime,$finalDate,$finalTime)
                    ->execute()
                    ->data;
    }

    /**
     * @param string $connection
     * @param string $table
     * @param int $stationSk
     * @param string $keys
     * @param string $select
     * @param int $initialDate
     * @param int $initialTime
     * @param int $finalDate
     * @param int $finalTime
     * @return mixed
     */
    public function getLocalDataWDT(string $connection, string $table, int $stationSk, string $keys, string  $select, int $initialDate, int $initialTime, int $finalDate, int $finalTime)
    {
        $query = new Query();

        $query->init($connection,$table)
            ->select($select)
            ->localWhere($stationSk,$initialDate,$initialTime,$finalDate,$finalTime)
            ->orderBy($keys)
            ->execute();

        return $query->data;
    }

    /**
     * @param string $connection
     * @param array $columns
     * @param array $data
     */
    public function insertDataWDT(string $connection, array $columns = [], array $data = [])
    {
        $insert = "INSERT INTO ".$this->etlConfig->tableSpaceWork." (".implode(',',$columns).") values ";

        foreach ($data as $can){
            $insert .= "( ";
            foreach ($can as $column){ $insert .= (is_null($column)) ? "NULL ," : "'$column'," ;}
            $insert[strlen($insert)-1] = ' ';
            $insert .= "),";
            //$insert .= "('".implode("','",(array)$can)."'),";
        }
        $insert[strlen($insert)-1] = ' ';

        DB::connection($connection)->statement($insert);
    }

    /**
     * @param RepositoriesContract $repository
     * @param $data
     * @return mixed
     */
    public function insertExistTableWDT(RepositoriesContract $repository,array $data)
    {
        return $repository->queryBuilder()->insert($data);
    }

    /**
     *
     */
    public  function migrateHistoricCorrection()
    {
        foreach (TemporaryCorrectionRepository::all() as $valueCorrection){
            CorrectionHistoryRepository::create($valueCorrection->toArray());
        }
        $this->truncateCorrectionTable();
    }

    /**
     *
     */
    public function truncateCorrectionTable()
    {
        TemporaryCorrectionRepository::truncate();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $time
     * @return bool
     */
    public function deleteLastDateWDT(RepositoriesContract $repository, $time) : bool
    {
        return $repository->queryBuilder()->where('time',$time)->delete();
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $variableName
     * @param array $infoCalculation
     * @return bool
     */
    public function generateVariableCalculatedWDT(RepositoriesContract $repository, string $variableName, array $infoCalculation) : bool
    {
        $values = $repository->queryBuilder()->select('id',$variableName)->whereNotNull($variableName)->get();

        foreach ($values as $value) {
            $repository->queryBuilder()->where('id',$value->id)->update([ $infoCalculation['destiny'] => round(((double)$value->{$variableName}) *  $infoCalculation['factor'],2)]);
        }
        return true;
    }

    /**
     * @param RepositoriesContract $repository
     * @param int $id
     * @param array $updates
     * @return mixed
     */
    public function updateDateTimeFromIdWDT(RepositoriesContract $repository, int $id, array $updates)
    {
        return $repository->queryBuilder()->where('id','=',$id)->update($updates);
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $variable
     * @param array $arr
     * @return mixed
     */
    public function deleteWhereInVariableWDT(RepositoriesContract $repository, string $variable, array $arr)
    {
        return $repository->queryBuilder()->whereIn($variable,$arr)->delete();
    }

    /**
     * @param RepositoriesContract $repository
     * @param array $inserts
     * @return mixed
     */
    public function insertDataArrayWDT(RepositoriesContract $repository, array $inserts)
    {
        return $repository->queryBuilder()->insert($inserts);
    }

    /**
     * @param RepositoriesContract $repository
     * @param int $id
     * @param array $variables
     * @return mixed
     */
    public function deleteAfterIdVariableWDT(RepositoriesContract $repository, int $id, array $variables)
    {
        return $repository->queryBuilder()->where('id', '>=' ,$id)->update($variables);
    }

    /**
     * @param RepositoriesContract $repository
     * @param int $initialId
     * @param int $finalId
     * @param array $variables
     * @return mixed
     */
    public function deleteInRangeIdVariableWDT(RepositoriesContract $repository, int $initialId, int $finalId, array $variables)
    {
        return $repository->queryBuilder()->whereBetween('id', [$initialId, $finalId])->update($variables);
    }

    /**
     * @param RepositoriesContract $repository
     * @param array $times
     * @return mixed
     */
    public function deleteEldestHomogenizationWDT(RepositoriesContract $repository, $times)
    {
        return $repository->queryBuilder()->whereNotIn('time_sk',(array)$times)->delete();
    }
}