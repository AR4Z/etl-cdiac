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
    public function getData(
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
    public function insertData(string $connection, string $table, $columns = [], $data = []){

        $insert = "INSERT INTO ".$table." (".implode(',',$columns).") values ";
        foreach ($data as $can){$insert .= "('".implode("' ,'",(array)$can)."'),";}
        $insert[strlen($insert)-1] = ' ';

        DB::connection($connection)->statement($insert);
    }

    public function evaluateExistence($repository,$data)
    {

        $count = ($repository)::where('fecha_sk','=',$data->fecha_sk)
                                ->where('estacion_sk','=',$data->estacion_sk)
                                ->where('tiempo_sk','=',$data->tiempo_sk)
                                ->count();

        return ($count != 0)? true : false;
    }

    public function insertExistTable($table,$data)
    {
        return DB::connection('temporary_work')->table($table)->insert($data);
    }

    public function getIncomingAmount($tableSpaceWork)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select(DB::raw('COUNT(id) AS count'))->get()->toArray()[0]->count;
    }

}