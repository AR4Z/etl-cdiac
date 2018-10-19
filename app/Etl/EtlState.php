<?php

namespace App\Etl;

use Exception;

class EtlState
{
    /**
     * @var array
     */
    public $errorsState = [];

    /**
     * @var array
     */
    public $warningsState = [];

    /**
     * @var array
     */
    public $infoState = [];

    /**
     * @var array
     */
    public $successState = [];

    /**
     * @var bool
     */
    public $stopProcessState = false;

    /**
     * @var bool
     */
    public $debug = true;

    /**
     * @param array $newError
     */
    public function addErrorsState(array $newError)
    {
        array_push($this->errorsState, $newError);
    }

    /**
     * @param array $newWarning
     */
    public function addWarningsState(array $newWarning)
    {
        array_push($this->warningsState, $newWarning);
    }

    /**
     * @param array $newInfo
     */
    public function addInfoState(array $newInfo)
    {
        array_push($this->infoState, $newInfo);
    }

    /**
     * @param array $newSuccess
     */
    public function addSuccessState(array $newSuccess)
    {
        array_push($this->successState, $newSuccess);
    }

    /**
     * @throws Exception
     */
    public function terminateProcessState()
    {
        $this->stopProcessState = true;

        if ($this->debug){ throw new Exception($this->warningsState[count($this->warningsState) -1 ]['exception']); }

        // TODO : metodo para terminar el proceso una vez que se a encontrado un error fatal

        dd('TODO: Terminar proceso EtlState.php',$this);
    }
}