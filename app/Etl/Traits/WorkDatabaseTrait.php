<?php

namespace App\Etl\Traits;

use App\Repositories\RepositoriesContract;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;
use Facades\App\Repositories\DataWareHouse\CorrectionHistoryRepository;
use Facades\App\Repositories\TemporaryWork\TemporaryCorrectionRepository;
use App\Etl\Database\Query;
use DB;
use Illuminate\Support\Collection;

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
     * @param int $limit
     * @return mixed
     */
    public function getExternalDataWDT(string $connection, string $table, string $keys, string $select, string $initialDate, string $initialTime, string $finalDate, string $finalTime, int $limit = null)
    {
        $query = new Query();

        return $query->init($connection,$table)
                    ->select($select)
                    ->externalWhereBetween($keys,$initialDate,$initialTime,$finalDate,$finalTime)
                    ->limit($limit)
                    ->execute()
                    ->data;
    }

    /**
     * @param string $connection
     * @param string $table
     * @param string $keys
     * @param string $select
     * @param string $initialDate
     * @param string $initialTime
     * @param string $finalDate
     * @param string $finalTime
     * @param int $limit
     * @return mixed
     */
    public function getLocalDataWDT(string $connection, string $table, string $keys, string $select, string $initialDate, string $initialTime, string $finalDate, string $finalTime, int $limit = null)
    {
        $query = new Query();

        $query->init($connection,$table)
            ->select($select)
            ->localWhere($initialDate,$initialTime,$finalDate,$finalTime)
            ->orderBy($keys)
            ->limit($limit)
            ->execute();

        //TODO -- probar la funcionalidad de este metodo --
        //dd($connection,$table,$keys,$select,$initialDate,$initialTime,$finalDate,$finalTime,$limit,$query->data);

        return $query->data;
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $select
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getAllDataWDT(RepositoriesContract $repository, string $select) : array
    {
        return $repository->queryBuilder()
                        ->select(DB::raw($select))
                        ->whereNotNull('station_sk')
                        ->whereNotNull('date_sk')
                        ->whereNotNull('time_sk')
                        ->get()
                        ->toArray();
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
     * @param array $data
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function insertDataEncodeWDT(RepositoriesContract $repository, array $data = []) : bool
    {
        $localData =  array_chunk(json_decode(json_encode($data),true),5000,true);

        foreach ($localData as $localValue){ $repository->queryBuilder()->insert($localValue);}

        return true;
    }

    /**
     * @param $repository
     * @param $data
     * @return bool
     */
    public function evaluateExistenceWDT(RepositoriesContract $repository, $data) : bool
    {
        $count = $repository->selectRaw('count(station_sk) AS count')
                            ->where('date_sk','=',$data->date_sk)
                            ->where('station_sk','=',$data->station_sk)
                            ->where('time_sk','=',$data->time_sk)
                            ->get()->toArray()[0]['count'];

        return ($count == 0) ? false : true;
    }

    /**
     * @param RepositoriesContract $repository
     * @param $data
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function insertExistTableWDT(RepositoriesContract $repository,array $data)
    {
        return $repository->queryBuilder()->insert($data);
    }

    /**
     * @param RepositoriesContract $repository
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getIncomingAmountWDT(RepositoriesContract $repository) : int
    {
        return $repository->queryBuilder()->select(DB::raw('COUNT(id) AS count'))->get()->toArray()[0]->count;
    }

    /**
     * @param RepositoriesContract $repository
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getLastMigrateDataWDT(RepositoriesContract $repository)
    {
        return $repository->queryBuilder()->orderby('id','DESC')->first();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $date_sk
     * @param $time
     * @param $interval
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getValInRangeWDT(RepositoriesContract $repository, $date_sk, $time, $interval) : Collection
    {
        return $repository->queryBuilder()
                    ->select('*')
                    ->where('date_sk', $date_sk)
                    ->whereBetween('time_sk',[$time,$interval])
                    ->orderby('date_sk','ASC')
                    ->orderby('time_sk','ASC')
                    ->get();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $date
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function countRowForDateWDT(RepositoriesContract $repository, $date)
    {
        return $repository->queryBuilder()->select('*')->where('date_sk',$date)->count();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $date_sk
     * @param $time_sk
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteFromDateAndTimeWDT(RepositoriesContract $repository, $date_sk, $time_sk)
    {
        return $repository->queryBuilder()
                    ->where('date_sk',$date_sk)
                    ->where('time_sk',$time_sk)
                    ->delete();
    }


    /**
     *
     */
    public  function migrateHistoricCorrection()
    {
        $temporaryCorrection = TemporaryCorrectionRepository::all();
        foreach ($temporaryCorrection as $valueCorrection){
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
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getInitialDataInSpaceWorkWDT(RepositoriesContract $repository)
    {
        return $repository->queryBuilder()->select('*')->orderByRaw("date_sk ASC, time_sk ASC")->first();
    }

    /**
     * @param RepositoriesContract $repository
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getFinalDataInSpaceWorkWDT(RepositoriesContract $repository)
    {
        return $repository->queryBuilder()->select('*')->orderByRaw("date_sk DESC, time_sk DESC")->first();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $variable
     * @param array $search
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getWhereInWDT(RepositoriesContract $repository, $variable, array $search) : Collection
    {
        return $repository->queryBuilder()
                    ->select('id','station_sk','date_sk','time_sk',$variable)
                    ->whereIn($variable,$search)
                    ->orderby('id')
                    ->get();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $time
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteLastDateWDT(RepositoriesContract $repository, $time) : bool
    {
        $value = $repository->queryBuilder()->select('id','time')->orderby('id','DESC')->first();

        if (!empty($value)){
            if ($value->time == $time){ $repository->queryBuilder()->where('id',$value->id)->delete();}
        }

        return true;
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $variableName
     * @param array $infoCalculation
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function generateVariableCalculatedWDT(RepositoriesContract $repository, string $variableName, array $infoCalculation) : bool
    {
        $values = $repository->queryBuilder()->select('id',$variableName)->whereNotNull($variableName)->get();

        foreach ($values as $value) {
            $repository->queryBuilder()
                ->where('id',$value->id)
                ->update([ $infoCalculation['destiny'] => round(((double)$value->{$variableName}) *  $infoCalculation['factor'],2)]);
        }
        return true;
    }

    /**
     * @param RepositoriesContract $repository
     * @param int $id
     * @param array $updates
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteWhereInVariableWDT(RepositoriesContract $repository, string $variable, array $arr)
    {
        return $repository->queryBuilder()->whereIn($variable,$arr)->delete();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $variable
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteNullVariableWDT(RepositoriesContract $repository, $variable)
    {
        return $repository->queryBuilder()->whereNull($variable)->delete();
    }

    /**
     * @param RepositoriesContract $repository
     * @param array $inserts
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function insertDataArrayWDT(RepositoriesContract $repository, array $inserts)
    {
        return $repository->queryBuilder()->insert($inserts);
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $variable
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function changeCommaForPointWDT(RepositoriesContract $repository, string $variable)
    {
        return $repository->queryBuilder()->update([ $variable => DB::raw( " REGEXP_REPLACE($variable,',','.') " )]);
    }

    /**
     * @param RepositoriesContract $repository
     * @param int $id
     * @param array $variables
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteInRangeIdVariableWDT(RepositoriesContract $repository, int $initialId, int $finalId, array $variables)
    {
        return $repository->queryBuilder()->whereBetween('id', [$initialId, $finalId])->update($variables);
    }

    /**
     * @param RepositoriesContract $repository
     * @param array $times
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteEldestHomogenizationWDT(RepositoriesContract $repository, $times)
    {
        return $repository->queryBuilder()->whereNotIn('time_sk',(array)$times)->delete();
    }

    /**
     * @param RepositoriesContract $repository
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getIdAndDateTimeWDT(RepositoriesContract $repository) : Collection
    {
        return $repository->queryBuilder()->select('id','date','time')->get();
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $key
     * @param string $column
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function selectColumnWhereNullWDT(RepositoriesContract $repository, string $key, string $column) : array
    {
        return $repository->queryBuilder()
            ->select($key)
            ->distinct($column) // TODO este distintic no recibe paametros...
            ->whereNull($column)
            ->orderBy($key)
            ->get()
            ->toArray();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $dateSk
     * @param null $date
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateDateFromDateSkWDT(RepositoriesContract $repository, $dateSk, $date = null)
    {
        return $repository->queryBuilder()->where('date_sk', '=',$dateSk)->update(['date'=> $date]);
    }

    /**
     * @param RepositoriesContract $repository
     * @param $timeSk
     * @param null $time
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateTimeFromTimeSkWDT(RepositoriesContract $repository, $timeSk, $time = null)
    {
        return $repository->queryBuilder()->where('time_sk', '=',$timeSk)->update(['time'=> $time]);
    }

    /**
     * @param RepositoriesContract $repository
     * @return mixed
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function getDuplicatesWDT(RepositoriesContract $repository) : array
    {
        return $repository->queryBuilder()
            ->selectRaw('station_sk,date_sk,time_sk, max(id)')
            ->groupBy('station_sk','date_sk','time_sk')
            ->havingRaw('count(station_sk) > 1')
            ->orderBy('station_sk','date_sk','time_sk') // TODO order by solo recibe dos paramtros la columna y el metodo de ordenamiento
            ->get()
            ->toArray();
    }

    /**
     * @param RepositoriesContract $repository
     * @param string $countSelect
     * @return Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function specificConsultValuesRawWDT(RepositoriesContract $repository, string $countSelect) : Collection
    {
        return $repository->queryBuilder()
            ->selectRaw('CAST(station_sk AS integer),CAST(date_sk AS integer),'.$countSelect)
            ->groupby('station_sk','date_sk')
            ->orderByRaw('station_sk asc,date_sk asc')
            ->get();
    }

    /**
     * @param RepositoriesContract $repository
     * @param $station_sk
     * @param $date_sk
     * @return array
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function firstStationAndDateWDT(RepositoriesContract $repository, $station_sk, $date_sk) : array
    {
        return (array)$repository->queryBuilder()->select('*')
            ->where('station_sk','=',$station_sk)
            ->where('date_sk','=',$date_sk)
            ->first();
    }

    /**
     * @param TemporalRepositoryContract $repository
     * @param $variable
     * @param $as
     * @return Collection
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function countVariableFromStationAndDateWDT(TemporalRepositoryContract $repository, $variable, $as) : Collection
    {
        return $repository->queryBuilder()
            ->selectRaw("CAST(station_sk AS integer),CAST(date_sk AS integer),COUNT($variable) AS $as")
            ->groupby('station_sk','date_sk')
            ->orderByRaw("station_sk asc,date_sk asc")
            ->get();
    }
}