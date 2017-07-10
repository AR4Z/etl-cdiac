<?php

namespace App\Etl\Traits;

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

        //dd($connection,$table,$keys,$select,$initialDate,$initialTime,$finalDate,$finalTime,$limit,$data);
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
        return DB::connection($connection)->table($table)->select(DB::raw($select))->get()->all();
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

    public function evaluateExistence($repository,$data)
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

}