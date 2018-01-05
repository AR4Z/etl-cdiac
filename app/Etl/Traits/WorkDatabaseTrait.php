<?php

namespace App\Etl\Traits;

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
     * @param int $limit
     * @return mixed
     */
    public function getExternalData(string $connection,string $table,string $keys,string $select,string $initialDate,string $initialTime,string $finalDate,string $finalTime,int $limit = null)
    {
        $query = new Query();
        return $query->init($connection,$table)->select($select)->externalWhereBetween($keys,$initialDate,$initialTime,$finalDate,$finalTime)->limit($limit)->execute()->data;
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
    public function getLocalData(string $connection,string $table,string $keys,string $select,string $initialDate,string $initialTime,string $finalDate,string $finalTime,int $limit = null)
    {
        $query = new Query();
        $query->init($connection,$table)->select($select)->localWhere($initialDate,$initialTime,$finalDate,$finalTime)->orderBy($keys)->limit($limit)->execute();
        //TODO -- probar la funcionalidad de este metodo --
        $data = $query->data;
        if (count($data) ==  0){
            dd('Error : No hay Datos para esta estacion en estas fechas');
        }

        //dd($connection,$table,$keys,$select,$initialDate,$initialTime,$finalDate,$finalTime,$limit,$query->data);
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
    public function serializationCorrect($tableSpaceWork,$variables,$stationSk,$arrayValue,$date,$time,$interval)
    {
        $arr = ['station_sk'=>$stationSk,'date_sk'=>$date,'time_sk'=>$time];
        foreach ($variables as $variable){
            if (!is_null($variable->correct_serialization)){
                $times = [];
                foreach ($arrayValue as $value){array_push($times,$value->time_sk);}
                //dd($variable,$stationSk,$arrayValue,$date,$time,$interval);
                $arr[$variable->local_name] = $this->{'Serialization'.ucwords($variable->correct_serialization)}($tableSpaceWork,$date,$times,$variable->local_name);
            }
        }

        $this->serializationInsert($tableSpaceWork,$arr);

        foreach ($arrayValue as $value){$this->SerializationDelete($tableSpaceWork,$value);}

    }
    public function SerializationDelete($tableSpaceWork,$value)
    {
        return DB::connection('temporary_work')
                    ->table($tableSpaceWork)
                    ->where('date_sk',$value->date_sk)
                    ->where('time_sk',$value->time_sk)
                    ->delete();
    }

    public function SerializationSum($tableSpaceWork,$date,$times,$variableName)
    {
        return DB::connection('temporary_work')
                    ->table($tableSpaceWork)
                    ->select(DB::raw("sum(CAST(".$variableName." AS FLOAT))"))
                    ->where('date_sk',$date)
                    ->whereIn('time_sk',$times)
                    ->get()[0]->sum;
    }
    public function SerializationAverage($tableSpaceWork,$date,$times,$variableName)
    {
        return DB::connection('temporary_work')
            ->table($tableSpaceWork)
            ->select(DB::raw("avg(CAST(".$variableName." AS FLOAT))"))
            ->where('date_sk',$date)
            ->whereIn('time_sk',$times)
            ->get()[0]->avg;
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