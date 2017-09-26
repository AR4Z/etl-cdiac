<?php

namespace App\Etl\Traits;

use Facades\App\Repositories\DataWareHouse\CorrectionHistoryRepository;
use Facades\App\Repositories\TemporaryWork\TemporaryCorrectionRepository;
use Carbon\Carbon;
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
     * @param int $limit
     * @return mixed
     */
    public function getExternalData(
        string $connection,
        string $table,
        string $keys,
        string $select,
        string $initialDate,
        string $initialTime,
        string $finalDate,
        string $finalTime,
        int $limit
    ){
        $data = DB::connection($connection)
            ->table($table)
            ->select(DB::raw($select))
            ->whereBetween(
                DB::raw("concat_ws(' ',".$keys.")"),
                [
                    Carbon::parse($initialDate.' '.$initialTime),
                    Carbon::parse($finalDate.' '.$finalTime),
                ]
            )
            ->orderby(DB::raw("concat_ws(' ',".$keys.")"), 'asc')
            ->limit($limit)
            ->get()
            ->all();

        return $data;
    }

    public function getLocalData(
        string $connection,
        string $table,
        string $keys,
        string $select,
        string $initialDate,
        string $initialTime,
        string $finalDate,
        string $finalTime,
        int $limit
    )
    {
        $data = DB::connection($connection)
            ->table($table)
            ->select(DB::raw($select))
            ->where(DB::raw("(((date_sk = $initialDate and time_sk >= $initialTime) or ( date_sk > $initialTime)) and ((date_sk = $finalDate) or (date_sk = $finalDate and time_sk <= $finalTime)))"))
            ->orderby(DB::raw($keys), 'asc')
            ->limit($limit)
            ->get()
            ->all();

        dd($connection,$table,$keys,$select,$initialDate,$initialTime,$finalDate,$finalTime,$limit,$data);
        return $data;
    }

    /**
     * @param string $connection
     * @param string $table
     * @param string $select
     * @return mixed
     */
    public function getAllData(string $connection, string $table, string $select)
    {
        return DB::connection($connection)->table($table)->select(DB::raw($select))->get()->toArray();
    }

    /**
     * @param string $connection
     * @param string $table
     * @param array $columns
     * @param array $data
     */
    public function insertData(string $connection, string $table, $columns = [], $data = [])
    {
        $insert = "INSERT INTO ".$table." (".implode(',',$columns).") values ";
        foreach ($data as $can){$insert .= "('".implode("' ,'",(array)$can)."'),";}
        $insert[strlen($insert)-1] = ' ';

        DB::connection($connection)->statement($insert);
    }
    /**
     * @param string $connection
     * @param string $table
     * @param array $data
     */
    public function insertDataEncode(string $connection, string $table, $data = [])
    {
        return DB::connection($connection)->table($table)->insert(json_decode(json_encode($data), true));
    }

    /**
     * @param $repository
     * @param $data
     * @return bool
     */
    public function evaluateExistence($repository, $data)
    {
        $count = ($repository)::where('date_sk','=',$data->date_sk)
                                ->where('station_sk','=',$data->station_sk)
                                ->where('time_sk','=',$data->time_sk)
                                ->count();

        return ($count != 0)? true : false;
    }

    /**
     * @param $table
     * @param $data
     * @return mixed
     */
    public function insertExistTable($table, $data)
    {
        return DB::connection('temporary_work')->table($table)->insert($data);
    }

    /**
     * @param $tableSpaceWork
     * @return mixed
     */
    public function getIncomingAmount($tableSpaceWork)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select(DB::raw('COUNT(id) AS count'))->get()->toArray()[0]->count;
    }

    /**
     * @param $tableSpaceWork
     * @return mixed
     */
    public function getLastMigrateData($tableSpaceWork)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->orderby('id','DESC')->first();
    }


    public function listDateAndTimeFromSpaceWork($tableSpaceWork)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select('date_sk','time_sk')->orderby('date_sk','ASC')->orderby('time_sk','ASC')->get();
    }

    public function getValInRange($tableSpaceWork,$date_sk,$time,$interval)
    {
        return DB::connection('temporary_work')
                    ->table($tableSpaceWork)
                    ->select('station_sk','date_sk','time_sk')
                    ->where('date_sk', $date_sk)
                    ->whereBetween('time_sk',[$time,$interval])
                    ->orderby('date_sk','ASC')
                    ->orderby('time_sk','ASC')
                    ->get();
    }

    public function serializationInsert($tableSpaceWork,$value)
    {
       DB::connection('temporary_work')->table($tableSpaceWork)->insert($value);
    }

    public function countRowForDate($tableSpaceWork,$date)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select('*')->where('date_sk',$date)->count();
    }

    public function serializationUpdate($repositorySpaceWork,$value,$date,$time)
    {
        $data = ($repositorySpaceWork)::select('*')->where('date_sk',$value->date_sk)->where('time_sk',$value->time_sk)->first();
        $data->date_sk = $date;
        $data->time_sk = $time;
        return $data->update();
    }
    public function serializationCorrect($arrayValue,$date,$time,$interval)
    {
        #TODO
    }

    /**
     *
     */
    public  function migrateHistoricCorrection()
    {
        $temporaryCorrection = TemporaryCorrectionRepository::all();
        foreach ($temporaryCorrection as $valueCorrection){CorrectionHistoryRepository::create($valueCorrection->toArray());}
        $this->truncateCorrectionTable();
    }

    /**
     *
     */
    public function truncateCorrectionTable()
    {
        TemporaryCorrectionRepository::truncate();
    }



}