<?php
namespace  App\Etl\Loaders;

use App\Etl\EtlBase;
use App\Etl\EtlConfig;
use Carbon\Carbon;
use DB;

abstract class LoadBase extends EtlBase
{
    /**
     * @var array
     */
    public $redirectExist = [];

    /**
     *
     */
    public function redirectExisting()
    {
        #Asegurar que el array de existentes este vacio
        $this->redirectExist = [];

        #Obtener los valores de la tabla te trabajo temporal
        $values = $this->etlConfig->repositorySpaceWork->all();

        foreach ($values as $value) {
            #Evaluar la existencia de los valores en su respectiva fact
            if ($this->etlConfig->repositoryDestination->evaluateExistence($value->station_sk,$value->date_sk,$value->time_sk)) {
                if (!$this->etlConfig->repositoryExist->evaluateExistence($value->station_sk,$value->date_sk,$value->time_sk)) {
                    #Extraer Dato existente en la fact respectiva
                    $exist = $this->etlConfig->repositoryExist->fill($value->toArray())->toArray();
                    #Insertar dato existente en la fact de existentes respectiva
                    $this->insertExistTableWDT($this->etlConfig->repositoryExist,$exist);

                    # Documentar los valores existentes en el array de control
                    array_push($this->redirectExist, $exist);
                }
                #Eliminar los valores existentes de la tabla tenporal de trabajo
                $this->etlConfig->repositorySpaceWork->deleteFromDateAndTime($value->date_sk,$value->time_sk);
            }
        }
    }

    /**
     * @param $stateTableValue
     * @param $date
     * @param $time
     * @param $response
     */
    public function updateDateAndTime($stateTableValue, $date, $time, $response)
    {
        $completeDate = Carbon::parse($date.' '.$time);
        $completeDate->addMinute();

        $stateTableValue->current_date = $completeDate->format('Y-m-d');
        $stateTableValue->current_time = $completeDate->format('h:i:s');
        $stateTableValue->updated =  $response;

        $stateTableValue->save();

    }

    /**
     *
     */
    public function calculateSequence()
    {
        if ($this->etlConfig->sequence){
            if (!is_null($data = $this->etlConfig->repositorySpaceWork->getLastMigrateData())) {
                $this->updateDateAndTime(
                    ($this->etlConfig->station)->{$this->etlConfig->stateTable},
                    $this->calculateDateFromDateSk($data->date_sk),
                    $this->calculateTimeFromTimeSk($data->time_sk),
                    ($this->etlConfig->sequence and Carbon::parse($this->etlConfig->finalDate) === Carbon::parse($this->calculateDateFromDateSk($data->date_sk))) ? true : false
                );
            }
        }
    }

    /**
     *
     */
    public function trustProcess()
    {
        $this->etlConfig->trustObject->generateTrustAndSupport(
            $this->etlConfig->varForFilter,
            ($this->etlConfig->station)->measurements_per_day
        );
    }
}