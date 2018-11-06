<?php
namespace  App\Etl\Loaders;

use App\Etl\EtlBase;
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function redirectExisting()
    {
        #Asegurar que el array de existentes este vacio
        $this->redirectExist = [];

        #Obtener los valores de la tabla te trabajo temporal
        $values = $this->etlConfig->repositorySpaceWork->all();

        foreach ($values as $value)
        {
            #Evaluar la existencia de los valores en su respectiva fact
            if ($this->evaluateExistenceWDT($this->etlConfig->repositoryDestination,$value))
            {
                #Extraer Dato existente en la fact respectiva
                $exist = $this->etlConfig->repositoryExist->fill($value->toArray())->toArray();

                if (!$this->evaluateExistenceWDT($this->etlConfig->repositoryExist,$value))
                {
                    #Insertar dato existente en la fact de existentes respectiva
                    $this->insertExistTableWDT($this->etlConfig->repositoryExist,$exist);

                    # Documentar los valores existentes en el array de control
                    array_push($this->redirectExist, $exist);
                }
                #Eliminar los valores existentes de la tabla tenporal de trabajo
                $this->deleteFromDateAndTimeWDT($this->etlConfig->repositorySpaceWork,$value->date_sk,$value->time_sk);
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function calculateSequence()
    {
        if ($this->etlConfig->sequence){

            $data = $this->getLastMigrateDataWDT($this->etlConfig->repositorySpaceWork);

            if (!is_null($data))
            {
                $response =  ($this->etlConfig->sequence and Carbon::parse($this->etlConfig->finalDate) == Carbon::parse($this->calculateDateFromDateSk($data->date_sk))) ? true : false;

                $this->updateDateAndTime(
                    ($this->etlConfig->station)->{$this->etlConfig->stateTable},
                    $this->calculateDateFromDateSk($data->date_sk),
                    $this->calculateTimeFromTimeSk($data->time_sk),
                    $response
                );
            }
        }
    }

    /**
     * @return bool
     */
    public function trustProcess()
    {
        if (!$this->etlConfig->isTrustProcess()){ return false;}

        $this->generateTrustAndSupport(
            $this->etlConfig->trustColumns,
            $this->etlConfig->varForFilter,
            ($this->etlConfig->station)->measurements_per_day
        );
    }
}