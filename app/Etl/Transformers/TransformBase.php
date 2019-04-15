<?php

namespace App\Etl\Transformers;

use App\Entities\Bodega\DateDim;
use App\Etl\EtlBase;
use App\Etl\EtlConfig;
use DB;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Arr;

abstract class TransformBase extends EtlBase
{
    /**
     * @param string $variable
     * @param null $overflowMaximum
     * @param null $overflowMinimum
     * @param null $overflowPreviousDeference
     * @param null $changeOverflowLower
     * @param null $changeOverflowHigher
     * @param null $changeOverflowPreviousDeference
     */
    public function overflow(
        string $variable,
        $overflowMaximum = null,
        $overflowMinimum = null,
        $overflowPreviousDeference = null,
        $changeOverflowLower = null,
        $changeOverflowHigher = null,
        $changeOverflowPreviousDeference = null
    )
    {
        $values =DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)
                    ->select('id','station_sk','date_sk','time_sk',DB::raw("CAST($variable AS double precision)"))
                    ->whereNotNull($variable)
                    ->orderby('id','DESC')
                    ->get();

        foreach ($values as $key => $value)
        {
            $floatValue = (float)$value->$variable;

            if(!is_null($overflowMaximum) and $floatValue > $overflowMaximum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowHigher,'outside_maximum_rank');
                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowHigher]);
                unset($values[$key]);
            }
            if (!is_null($overflowMinimum) and $floatValue < $overflowMinimum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowLower,'outside_minimum_rank');
                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowLower]);
                unset($values[$key]);
            }
        }

        if(!is_null($overflowPreviousDeference)){
            if (!is_null($values)){
                foreach ($values as $key =>$value){

                    $previous_value = DB::connection('temporary_work')
                        ->table($this->etlConfig->tableSpaceWork)
                        ->select('id',DB::raw("CAST($variable AS double precision)"))
                        ->where('date_sk', '<=' ,$value->date_sk)
                        ->where('time_sk', '<' ,$value->time_sk)
                        ->orderBy('date_sk', 'DESC')
                        ->orderBy('time_sk', 'DESC')
                        ->first();

                    if (!is_null($previous_value)){
                        if (!is_null($previous_value->$variable)){
                            $deference = abs($value->$variable - $previous_value->$variable);
                            if ($deference > $overflowPreviousDeference){
                                $this->insertInCorrectionTable($value,$variable,$changeOverflowPreviousDeference,'outside_previous_deference');
                                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowPreviousDeference]);
                                unset($values[$key]);
                            }
                        }

                    }
                }
            }
        }
        return;
    }

    /**
     * @param string $variable
     * @param $deleteLastHour
     * @param $spaceTimeDelete
     * @return bool
     */
    public function updateRageTime(string $variable, $deleteLastHour, $spaceTimeDelete)
    {
        if (is_null($values = $this->etlConfig->repositorySpaceWork->getVariableToSearchLimit($variable,$deleteLastHour))){ return false;}

        # MaxValueSk esta en TimeSkTrait: es el ultimo tiempo sk en la tabla
        $limit = $this->maxValueSk - $spaceTimeDelete;

        foreach ($values as $value){
            $secondTimeSk = $value->time_sk + $spaceTimeDelete;
            $secondDateSk = $value->date_sk;

            if ($limit <= $value->time_sk){ $secondTimeSk = $value->time_sk - $limit; $secondDateSk += 1; }

            if ($value->date_sk = $secondDateSk){
                $this->updateInRange($variable,$value->date_sk,$value->time_sk,$secondTimeSk,null);
            }else{
                $this->updateInRange($variable,$value->date_sk,$value->time_sk,$limit,null);
                $this->updateInRange($variable,$secondDateSk,$value->time_sk,$limit,null);
            }
        }

        return true;
    }

    /**
     * @param string $variable
     * @param $initDateSk
     * @param $initTimeSk
     * @param $finalTimeSk
     * @param null $valueForChange
     * @return bool
     */
    public function updateInRange(string $variable, $initDateSk, $initTimeSk, $finalTimeSk, $valueForChange = null)
    {
        $query  = DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('date_sk','=',$initDateSk)->where('time_sk','>=', $initTimeSk)->where('time_sk', '<=', $finalTimeSk);

        # Extraer todos los campos que cumplen las condiciones
        $values = $query->get();

        # Ingresar los valores que no son null al historial de correciones
        foreach ($values as $value) { if (!is_null($value->$variable)){ $this->insertInCorrectionTable($value,$variable,$valueForChange,'span_zero');}}

        # Editar los campos que cumplen las condiciones
        $query->update([$variable => $valueForChange]);

        return true;
    }

    /**
     * @param $variables
     * @return bool
     */
    public function trustProcess($variables)
    {
        if (is_null($variables->reliability_name)){return false;}

        $this->etlConfig->trustObject->insertGoods(
            $this->etlConfig->repositorySpaceWork,
            $this->etlConfig->station->id,
            $variables->local_name,
            $variables->reliability_name
        );
    }

    /**
     * @param string $variable
     * @param array $searchParams
     * @return bool
     */
    public function updateForNull(string $variable, array $searchParams = ['-'])
    {
       $values =  DB::connection('temporary_work')
                       ->table($this->etlConfig->tableSpaceWork)
                       ->select('id','station_sk','date_sk','time_sk',$variable)
                       ->whereIn($variable,$searchParams)
                       ->get();

       if (is_null($values) or empty($values)){return false;}

       foreach ($values as $value ) {$this->insertInCorrectionTable($value,$variable,null,'known_error_value');}

        DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->whereIn($variable,$searchParams)->update([$variable => null]);

       return true;

    }

    /**
     * @param $value
     * @param $variable
     * @param null $change
     * @param null $observation
     */
    private function insertInCorrectionTable($value, $variable, $change = null, $observation = null)
    {
        DB::connection('temporary_work')
                ->table('temporary_correction')
                ->insert([
                    'temporary_id'  => $value->id,
                    'station_sk'    => $value->station_sk,
                    'date_sk'       => $value->date_sk,
                    'time_sk'       => $value->time_sk,
                    'variable'      => $variable,
                    'error_value'   => $value->$variable,
                    'correct_value' => $change,
                    'observation'   => $observation,
                ]);
    }

    /**
     * @param array $params
     */
    public function setParamSearch(array $params)
    {
        foreach ($params as $param){ $this->paramSearch[] = $param;}
    }

    public function filterWindSpeedZero()
    {
        return DB::connection('temporary_work')
            ->table($this->etlConfig->tableSpaceWork)
            ->whereNotNull('wind_direction')
            ->where(function ($query){$query->whereRaw('CAST(wind_speed AS FLOAT) = 0')->orWhere('wind_speed','=',null);})
            ->update(['wind_direction' => null, 'comment' => DB::raw("CONCAT(comment,  ' filterWindSpeedZero -' )")]);
    }

    /**
     * @param $variables
     * @return bool
     */
    public function filterCappedRainGauge(array $variables) : bool
    {
        # Se consultan los valores en el rango de PTI y PTF en los comentarios
       $result = $this->etlConfig->repositorySpaceWork->gerElementsWhereInComments('PTI','PTF');

       # Se sale si no encuentra valores
       if ($countData = count($result) == 0){ return false;}

       # Se ejecuta el proceso de eliminacion cuando es una sola opcion ya sea PTI o PTF
       if ($countData == 1){
           return $this->deleteOneConditionalVariableWDT($this->etlConfig->repositorySpaceWork, $result[0]->id, (Arr::get((array)Arr::first($result),'comment',false) == 'PTI') ? '>=' : '<=', $variables);
       }

       # Se valida que no hallan valores de PTI o PTF seguidos es decir (PTI-PTI o PTF-PTF) y se separan por parejas dependiendo de las caracteristicas
       $result = $this->separatePartnerElements($this->validateConsecutiveElements($result,'PTI','PTF'),'banderCRG','PTI','PTF');

       # Se recorren las parejas y se redirreccional al metodo correspondiente
       foreach ($result as $key => $value){
           if (count($value) == 1){
               $this->deleteOneConditionalVariableWDT($this->etlConfig->repositorySpaceWork, $value[0]->id, (Arr::get((array)Arr::first($value),'comment',false) == 'PTI') ? '>=' : '<=', $variables);
           }else{
               $this->deleteTwoConditionalVariableWDT($this->etlConfig->repositorySpaceWork, $value[0]->id, $value[1]->id, $variables);
           }
       }

       return true;
    }

    /**
     * @param array $elements
     * @param string $variable
     * @param string $init
     * @param string $final
     * @return array
     */
    public function separatePartnerElements(array $elements, string $variable, string $init, string $final) : array
    {
        $arrGlo = [];
        $arrTem = [];

        foreach ($elements as $key => $value) {
            if (count($arrTem) == 0){
                if ($value->$variable == $final){$arrGlo[] = [$value];}else{$arrTem[] = $value;}
            }else{
                if ($arrTem[0]->$variable == $value->$variable){
                    $arrGlo[] = $arrTem;
                    $arrTem = [];
                    $arrTem[] = $value;
                }else{
                    $arrTem[] = $value;
                    $arrGlo[] = $arrTem;
                    $arrTem = [];
                }
            }
        }

        if (count($arrTem) !== 0){$arrGlo[] = $arrTem;}

        return $arrGlo;
    }

    /**
     * @param array $elements
     * @param string $init
     * @param string $final
     * @return array
     */
    public function validateConsecutiveElements(array $elements,string $init,string $final) : array
    {
        $flag = '';
        $arr = [];
        foreach ($elements as $key => $var){
            $var->banderCRG = (is_numeric(strpos($var->comment,$init))) ? $init : $final;
            if ($var->banderCRG == $flag){ if ($flag == $final){ $arr[count($arr)-1] = $var; }}else{$arr[] = $var;}
            $flag = $var->banderCRG;
        }
        return $arr;
    }

    /**
     * @param $date
     * @param $time
     * @return mixed
     */
    public function getElementInFact($date, $time)
    {
        return DB::connection('data_warehouse')
            ->table($this->etlConfig->tableDestination)
            ->select('*')
            ->where('date_sk','=',$date)
            ->where('time_sk','>=',$time)
            ->first();
    }

    /**
     * @param $date
     * @param $time
     * @return mixed
     */
    public function getElementInTemporal($date, $time)
    {
        return DB::connection('temporary_work')
            ->table($this->etlConfig->tableSpaceWork)
            ->select('*')
            ->where('date_sk','=',$date)
            ->where('time_sk','>=',$time)
            ->first();
    }
}
