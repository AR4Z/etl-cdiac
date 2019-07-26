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
    public function addErrorsState(array $newError) : void
    {
        $this->errorsState[] = $newError;
    }

    /**
     * @param array $newWarning
     */
    public function addWarningsState(array $newWarning) : void
    {
       $this->warningsState[] = $newWarning;
    }

    /**
     * @param array $newInfo
     */
    public function addInfoState(array $newInfo) : void
    {
        $this->infoState[] =  $newInfo;
    }

    /**
     * @param array $newSuccess
     */
    public function addSuccessState(array $newSuccess) : void
    {
        $this->successState[] = $newSuccess;
    }

    /**
     * @throws Exception
     */
    public function terminateProcessState() : void
    {
        $this->stopProcessState = true;

        if ($this->debug){
            $exception = $this->warningsState[count($this->warningsState) -1 ]['exception'];
            if (!is_null($exception)){
                //throw new Exception($exception);
                dd($this);
            }
        }

        // TODO : metodo para terminar el proceso una vez que se a encontrado un error fatal

        dd('TODO: Terminar proceso EtlState.php',$this);
    }
}