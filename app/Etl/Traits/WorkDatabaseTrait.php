<?php

namespace App\Etl\Traits;

use Carbon\Carbon;
use DB;

trait WorkDatabaseTrait
{
    /**
     * @param $connection
     * @param $table
     * @param $select
     * @param $initialDate
     * @param $initialTime
     * @param $finalDate
     * @param $finalTime
     * @param $limit
     * @return mixed
     */
    public function getData(
        string $connection,
        string $table,
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
                DB::raw("concat_ws(' ',fecha, hora)"),
                [
                    Carbon::parse($initialDate.' '.$initialTime),
                    Carbon::parse($finalDate.' '.$finalTime),
                ]
            )
            ->orderby(DB::raw("concat_ws(' ',fecha, hora)"), 'asc')
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
    public function getAllData(string $connection, string $table, string $select){

        return DB::connection($connection)->table($table)->select(DB::raw($select))->get()->all();
    }

    /**
     * @param string $connection
     * @param string $table
     * @param array $data
     */
    public function insertData(string $connection, string $table, $data = []){
        foreach ($data as $can){
            $dataSet = array();
            foreach ($can as $key => $value){
                $dataSet[$key] = $value;
            }

            DB::connection($connection)->table($table)->insert($dataSet);
        }
    }
}