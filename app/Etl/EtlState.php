<?php

namespace App\Etl;

class EtlState
{
    public $errorsState = [];

    public $warningsState = [];

    public $infoState = [];

    public $successState = [];

    public $stopProcessState = false;

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

    public function terminateProcessState()
    {
        $this->stopProcessState = true;

        // TODO : metodo para terminar el proceso una vez que se a encontrado un error fatal

        dd('TODO: Terminar proceso EtlState.php');
    }
}