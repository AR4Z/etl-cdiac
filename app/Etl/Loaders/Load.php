<?php


namespace App\Etl\Loaders;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use App\Repositories\RepositoriesContract;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;
use Exception;
use Illuminate\Support\Arr;

class Load extends LoadBase implements LoadInterface,StepContract
{
    /**
     * @var string
     */
    public $method = 'General';

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @var string
     */
    public $select = '';

    /**
     * @var array
     */
    public  $columns = [];

    /**
     * @var bool
     */
    public $deleteDuplicates = true;

    /**
     *
     */
    public function run()
    {
        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());

        # Se ejecutan los pasos que se requieren para el proceso
        $this->stepsList->runStartList($this->etlConfig->processState,$this);
    }

    /**
     * EL ORDEN DE LOS PASOS ES MUY IMPORTANTE
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList) : StepList
    {
        $stepList->addStep( new Step('stepExtractConfigurationPrimaryKeys'));
        $stepList->addStep( new Step('stepExtractColumnsExtra'));
        $stepList->addStep( new Step('stepConfigureSelect'));
        $stepList->addStep( new Step('stepRedirectExisting'));
        $stepList->addStep( new Step('stepDeleteDuplicates'));
        $stepList->addStep( new Step('stepCalculateDateTime'));
        $stepList->addStep( new Step('stepExtractTemporalAndInsertFact'));
        $stepList->addStep( new Step('stepTrustProcess'));
        $stepList->addStep( new Step('stepMigrateHistoryCorrection'));
        $stepList->addStep( new Step('stepUpdateSequence'));

        return $stepList;
    }

    /**
     * STEP
     * Extraer las configuraciones de llaves perimarias
     * @return array
     */
    public function stepExtractConfigurationPrimaryKeys()
    {
        try {
            $this->select = $this->etlConfig->keys->loadCastKey;

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Extraer las columnas que se deben ingrear que no estan el base de datos (keys and comment and etc)
     * @return array
     */
    public function stepExtractColumnsExtra()
    {
        try {
            $this->columns = $this->etlConfig->keys->load;

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Configuración de la consulta para extraer los datos de temporal_work
     * @return array
     */
    public function stepConfigureSelect()
    {
        try {
            $this->setSelect('local_name','local_name');

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Direccionar los datos existentes a la tabla de existentes
     * @return array
     */
    public function stepRedirectExisting()
    {
        try {
            $this->redirectExisting();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Eliminar los duplicados
     * @return array
     */
    public function stepDeleteDuplicates()
    {
        try {
            $this->deleteDuplicates($this->etlConfig->repositorySpaceWork);

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Se calcula la fechas cuando son null
     * Se calcula la hora cuando es null
     * Se calcula el date_time
     * @return array
     */
    public function stepCalculateDateTime()
    {
        try {
            if ($this->etlConfig->isCalculateDateTime()) {
                # Se calcula la fechas cuando son null
                $this->completeDateNull();

                # Se calcula la hora cuando es null
                $this->completeTimeNull();

                # Se calcula el date_time
                $this->InsertDateTime();
            }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Extraer valores de la tabla temporal
     * Insertar datos en en su respectiva fact
     * @return array
     */
    public function stepExtractTemporalAndInsertFact()
    {
        try {
            # Extraer valores de la tabla temporal
            $values = $this->selectTemporalTable();

            # Insertar datos en en su respectiva fact
            if (!empty($values)){ $this->insertAllDataInFact($values); }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Calcular la confienza y el soporte
     * @return array
     */
    public function stepTrustProcess()
    {
        try {
            $this->trustProcess();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Migrar los datos de correccion a historial de correccion
     * @return array
     */
    public function stepMigrateHistoryCorrection()
    {
        try {
            if ($this->etlConfig->typeProcess != "Original"){ $this->migrateHistoricCorrection();}

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }


    /**
     * STEP
     * Actualizar las fechas y horas del migrado
     * @return array
     */
    public function stepUpdateSequence()
    {
        try {
            $this->calculateSequence();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }


    /**
     * @param $colOrigin
     * @param $colDestination
     * @return $this
     */
    public function setSelect($colOrigin, $colDestination)
    {
        $variables= $this->etlConfig->varForFilter;
        $temporalSelect = '';

        if ($this->etlConfig->typeProcess !== "Original"){
            foreach ($variables as $variable){
                $temporalSelect .= 'CAST('.$variable->$colOrigin.' AS float) AS '. $variable->$colDestination.', ';
                $this->columns[] = $variable->$colDestination;
            }
        }else{
            foreach ($variables as $variable){
                $temporalSelect .= $variable->$colOrigin.' AS '. $variable->$colDestination.', ';
                $this->columns[] = $variable->$colDestination;
            }
        }

        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }

    /**
     * @return mixed
     */
    public function selectTemporalTable()
    {
        return $this->etlConfig->repositorySpaceWork->getAllDataPersonalSelect($this->select);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function insertAllDataInFact($data)
    {
       return $this->etlConfig->repositoryDestination->insertDataEncode($data);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     *
     */
    public function InsertDateTime()
    {
        $val = $this->etlConfig->repositorySpaceWork->getIdAndDateTime();

        foreach ($val as $item) {
            $this->updateDateTimeFromIdWDT(
                $this->etlConfig->repositorySpaceWork,
                $item->id,
                [ 'date_time'=> $item->date.''. (is_null($item->time) ? '' : ' '.$item->time ) ]
            );
        }
    }

    /**
     *
     */
    public function completeDateNull()
    {
        $datesNull = $this->etlConfig->repositorySpaceWork->selectColumnWhereNull('date_sk','date');

        foreach ($datesNull as $dates) {
            $this->etlConfig->repositorySpaceWork->updateDateFromDateSk($dates->date_sk, $this->calculateDateFromDateSk($dates->date_sk));
        }
    }

    /**
     *
     */
    public function completeTimeNull()
    {
        $timesNull = $this->etlConfig->repositorySpaceWork->selectColumnWhereNull('time_sk','time');

        foreach ($timesNull as $time) {
            if($time->time_sk < $this->maxValueSk){
                $this->etlConfig->repositorySpaceWork->updateTimeFromTimeSk($time->time_sk, $this->calculateTimeFromTimeSk($time->time_sk));
            }
        }
    }

    /**
     * Se el ultimo dato entrante cuando se ingresan datos duplicados
     * @param TemporalRepositoryContract $repository
     * @return bool
     */
    public function deleteDuplicates(TemporalRepositoryContract $repository) : bool
    {
        if (!$this->deleteDuplicates){ return false;}

        # se extrae el maximo id cuando existen datos duplicados
        $result = $repository->getDuplicates($this->etlConfig->station->id);

        if (count($result) == 0){return false;}

        # se eliminan los id's duplicados
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork, 'id', Arr::pluck($result,'max'));

        return true;
    }

    /**
     * @param bool $deleteDuplicates
     */
    public function setDeleteDuplicates(bool $deleteDuplicates)
    {
        $this->deleteDuplicates = $deleteDuplicates;
    }


}