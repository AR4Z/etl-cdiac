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
        $query->init($connection,$table)
            ->select($select)
            ->localWhere($initialDate,$initialTime,$finalDate,$finalTime)
            ->orderBy($keys)
            ->limit($limit)
            ->execute();
        //TODO -- probar la funcionalidad de este metodo --
        $data = $query->data;
        if (count($data) ==  0){
            //dd('Error : No hay Datos para esta estacion en estas fechas');
            echo ("Error : No hay Datos para esta estacion  en estas fechas: $initialDate $initialTime -- $finalDate $finalTime");
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
        return DB::connection($connection)->table($table)->select(DB::raw($select))
            ->whereNotNull('station_sk')->whereNotNull('date_sk')->whereNotNull('time_sk')
            ->get()->toArray();
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
     * @param string $connection
     * @param string $table
     * @param array $data
     * @return
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
        return ($count == 0)? false : true;
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

    /**
     * @param $tableSpaceWork
     * @return mixed
     */
    public function listDateAndTimeFromSpaceWork($tableSpaceWork)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select('date_sk','time_sk')->orderby('date_sk','ASC')->orderby('time_sk','ASC')->get();
    }

    /**
     * @param $tableSpaceWork
     * @param $date_sk
     * @param $time
     * @param $interval
     * @return mixed
     */
    public function getValInRange($tableSpaceWork, $date_sk, $time, $interval)
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

    /**
     * @param $tableSpaceWork
     * @param $value
     */
    public function serializationInsert($tableSpaceWork, $value)
    {
       DB::connection('temporary_work')->table($tableSpaceWork)->insert($value);
    }

    /**
     * @param $tableSpaceWork
     * @param $date
     * @return mixed
     */
    public function countRowForDate($tableSpaceWork, $date)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->select('*')->where('date_sk',$date)->count();
    }

    /**
     * @param $repositorySpaceWork
     * @param $value
     * @param $date
     * @param $time
     * @return mixed
     */
    public function serializationUpdate($repositorySpaceWork, $value, $date, $time)
    {
        $data = ($repositorySpaceWork)::select('*')->where('date_sk',$value->date_sk)->where('time_sk',$value->time_sk)->first();
        $data->date_sk = $date;
        $data->time_sk = $time;
        return $data->update();
    }

    /**
     * @param $tableSpaceWork
     * @param $variables
     * @param $stationSk
     * @param $arrayValue
     * @param $date
     * @param $time
     * @param $interval
     */
    public function serializationCorrect($tableSpaceWork, $variables, $stationSk, $arrayValue, $date, $time, $interval)
    {
        $arr = ['station_sk'=>$stationSk,'date_sk'=>$date,'time_sk'=>$time];

        #hayar las variables de la estacion a corregir
        foreach ($variables as $variable){
            if (!is_null($variable->correct_serialization)){
                $times = [];
                foreach ($arrayValue as $value){array_push($times,$value->time_sk);}
                $arr[$variable->local_name] = $this->{'Serialization'.ucwords($variable->correct_serialization)}($tableSpaceWork,$date,$times,$variable->local_name);
            }
        }

        #Eliminar los valores actuales en el espacio de trabajo
        foreach ($arrayValue as $value){$this->deleteFromDateAndTime($tableSpaceWork,$value->date_sk,$value->time_sk);}

        #Insertar la Correcion en el espacio de trabajo
        $this->serializationInsert($tableSpaceWork,$arr);

    }

    /**
     * @param $tableSpaceWork
     * @param $date_sk
     * @param $time_sk
     * @return mixed
     */
    public function deleteFromDateAndTime($tableSpaceWork, $date_sk, $time_sk)
    {
        return DB::connection('temporary_work')
                    ->table($tableSpaceWork)
                    ->where('date_sk',$date_sk)
                    ->where('time_sk',$time_sk)
                    ->delete();
    }

    /**
     * @param $tableSpaceWork
     * @param $date
     * @param $times
     * @param $variableName
     * @return mixed
     */
    public function SerializationSum($tableSpaceWork, $date, $times, $variableName)
    {
        return DB::connection('temporary_work')
                    ->table($tableSpaceWork)
                    ->select(DB::raw("sum(CAST(".$variableName." AS FLOAT))"))
                    ->where('date_sk',$date)
                    ->whereIn('time_sk',$times)
                    ->get()[0]->sum;
    }

    /**
     * @param $tableSpaceWork
     * @param $date
     * @param $times
     * @param $variableName
     * @return mixed
     */
    public function SerializationAverage($tableSpaceWork, $date, $times, $variableName)
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

    /**
     * @param $repository
     * @return mixed
     */
    public function getInitialDataInSpaceWork($repository)
    {
        return ($repository)::select('*')->orderByRaw("date_sk ASC, time_sk ASC")->first();
    }

    /**
     * @param $repository
     * @return mixed
     */
    public function getFinalDataInSpaceWork($repository)
    {
        return ($repository)::select('*')->orderByRaw("date_sk DESC, time_sk DESC")->first();
    }

    /**
     * @param $tableSpaceWork
     * @param $variable
     * @param array $search
     * @return mixed
     */
    public function getWhereIn($tableSpaceWork, $variable, array $search)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)
                    ->select('id','station_sk','date_sk','time_sk',$variable)
                    ->whereIn($variable,$search)
                    ->orderby('id')
                    ->get();
    }

    /**
     * @param $tableSpaceWork
     * @param $time
     * @return bool
     */
    public function deleteLastDate($tableSpaceWork, $time)
    {
        $query = DB::connection('temporary_work')->table($tableSpaceWork);

        $value =  $query->select('id','time')->orderby('id','DESC')->first();

        if ($value->time = $time){ $query->where('id',$value->id)->delete(); }

        return true;
    }


    /**
     * @param string $tableSpaceWork
     * @param string $variableName
     * @param array $infoCalculation
     * @return bool
     */
    public function generateVariableCalculated(string $tableSpaceWork, string $variableName, array $infoCalculation)
    {
        $values = DB::connection('temporary_work')->table($tableSpaceWork)->select('id',$variableName)->whereNotNull($variableName)->get();

        foreach ($values as $value) {
            DB::connection('temporary_work')
                ->table($tableSpaceWork)
                ->where('id',$value->id)
                ->update([
                        $infoCalculation['destiny'] => round(((double)$value->{$variableName}) *  $infoCalculation['factor'],2)
                    ]
                );
        }
        return true;
    }

    /**
     * @param string $tableSpaceWork
     * @param int $id
     * @param string $date
     * @param string $time
     * @return mixed
     */
    public function updateDateTimeFromId(string $tableSpaceWork, int $id, string $date, string $time)
    {
      return DB::connection('temporary_work')->table($tableSpaceWork)->where('id',$id)->update(['date' => $date,'time' => $time]);
    }

    /**
     * @param string $tableSpaceWork
     * @param string $variable
     * @param array $arr
     * @return mixed
     */
    public function deleteWhereInVariable(string $tableSpaceWork, string $variable, array $arr)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->whereIn($variable,$arr)->delete();
    }

    public function deleteNullVariable($tableSpaceWork,$variable)
    {
        return DB::connection('temporary_work')->table($tableSpaceWork)->whereNull($variable)->delete();
    }
}