<?php
namespace  App\Etl\Loaders;

use App\Etl\Traits\{DateSkTrait,TimeSkTrait,WorkDatabaseTrait,TrustTrait};
use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use DB;

abstract class LoadBase
{
    use WorkDatabaseTrait,DateSkTrait,TimeSkTrait,TrustTrait;

    public $redirectExist = [];

    /**
     *
     */
    public function redirectExisting()
    {
        #Asegurar que el array de existentes este vacio
        $this->redirectExist = [];

        #Obtener los valores de la tabla te trabajo temporal
        $values = ($this->etlConfig->getRepositorySpaceWork())::all();
        foreach ($values as $value)
        {
            #Evaluar la existencia de los valores en su respectiva fact
            if ($this->evaluateExistence($this->etlConfig->getRepositoryDestination(),$value))
            {
                #Extraer Dato existente en la fact respectiva
                $exist = ($this->etlConfig->getRepositoryExist())::fill($value->toArray())->toArray();

                if (!$this->evaluateExistence($this->etlConfig->getRepositoryExist(),$value))
                {
                    #Insertar dato existente en la fact de existentes respectiva
                    $this->insertExistTable($this->etlConfig->getTableExist(),$exist);

                    # Documentar los valores existentes en el array de control
                    array_push($this->redirectExist, $exist);
                }
                #Eliminar los valores existentes de la tabla tenporal de trabajo
                $this->deleteFromDateAndTime($this->etlConfig->getTableSpaceWork(),$value->date_sk,$value->time_sk);
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
        $data = $this->getLastMigrateData($this->etlConfig->geTtableSpaceWork());
        if (!is_null($data))
        {
           $response =  ($this->etlConfig->getSequence() and Carbon::parse($this->etlConfig->getFinalDate()) == Carbon::parse($this->calculateDateFromDateSk($data->date_sk))) ? true : false;

            $this->updateDateAndTime(
                $this->etlConfig->getStation()->{$this->etlConfig->getStateTable()},
                $this->calculateDateFromDateSk($data->date_sk),
                $this->calculateTimeFromTimeSk($data->time_sk),
                $response
            );
        }
    }

    public function trustProcess()
    {
        if (!$this->etlConfig->isTrustProcess()){ return false;}

        $this->generateTrustAndSupport(
            $this->etlConfig->getTrustColumns(),
            $this->etlConfig->getVarForFilter(),
            $this->etlConfig->getStation()->measurements_per_day
        );
    }
}