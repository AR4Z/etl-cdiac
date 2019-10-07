<?php

namespace App\Etl\Steps;

use App\Etl\EtlState;
use Carbon\Carbon;
use Exception;

class Step
{
    /**
     * @var string
     */
    public $method = '';

    /**
     * @var array
     */
    public $params = [];

    /**
     * @var bool
     */
    public $requireParams = false;

    /**
     * @var bool
     */
    public $terminate = false;

    /**
     * @var bool
     */
    public $inProcess = false;

    /**
     * @var array
     */
    public $return = null;

    /**
     * @var bool
     */
    public $requireReturn = false;

    /**
     * @var bool
     */
    public $error = false;

    /**
     * @var Carbon
     */
    public $create = null;

    /**
     * @var Carbon
     */
    public $started = null;

    /**
     * @var Carbon
     */
    public $finalization = null;

    /**
     * Step constructor.
     * @param string $method
     */
    public function __construct(string $method = '')
    {
        $this->create = Carbon::now();

        $this->method = $method;
    }

    /**
     * @param EtlState $etlState
     * @param $process
     * @return array|null
     * @throws Exception
     */
    public function start(EtlState $etlState,$process)
    {
        $this->started =  Carbon::now();

        $this->inProcess = true;

        $resultExecute = $this->executeStep($etlState,$process);

        $this->validateResultExecution($etlState,$resultExecute);

        $validate = $this->validateReturn($etlState);

        if (!$validate){ $etlState->terminateProcessState(); }

        $this->inProcess = false;
        $this->terminate = true;

        $etlState->addSuccessState([
            'localization' => 'App\Etl\Steps@start',
            'description'  => 'terminado exitosamente el paso : '.$this->method
        ]);

        $this->finalization = Carbon::now();

        return ($validate) ? $this->return : null;
    }

    /**
     * @param EtlState $etlState
     * @return bool
     */
    public function validateReturn(EtlState $etlState) : bool
    {
        if ($this->error){ return false;}

        if ($this->requireReturn) {
            if (is_null($this->return)){
                $this->error = true;
                $etlState->addErrorsState([
                    'localization' => 'App\Etl\Steps@validateReturn',
                    'description'  => 'Es obligatorio retorar un valor para '.$this->method.' y no se esta retornando'
                ]);

                return false;
            }
        }

        return true;
    }

    /**
     * @param EtlState $etlState
     * @param $process
     * @return null
     */
    public function executeStep(EtlState $etlState,$process)
    {
        $temporalReturn = null;

        if ($this->requireParams){
            if (count($this->params) > 0){
                $temporalReturn = $process->{$this->method}($this->params);
            }else{
                $this->error = true;

                $etlState->addErrorsState([
                    'localization' => 'App\Etl\Steps@executeStep',
                    'description' => 'Es obligatorio ingresar parametros para '.$this->method.' y no se esta ingresando'
                ]);
            }
        }else{
            $temporalReturn = $process->{$this->method}();
        }

        return $temporalReturn;

    }

    /**
     * @param EtlState $etlState
     * @param array $temporalReturn
     */
    public function validateResultExecution(EtlState $etlState,array $temporalReturn = [])
    {
        if (count($temporalReturn) > 0){
            if ($temporalReturn['resultExecution']){

                $this->return = $temporalReturn['data'];

                $etlState->addInfoState([
                    'localization' => 'App\Etl\Steps@validateResultExecution',
                    'description'  => 'terminado el paso '.$this->method
                ]);

            }else{
                $this->error = true;

                $etlState->addWarningsState([
                    'localization' => 'App\Etl\Steps@validateResultExecution',
                    'description'  => 'Hubo un error en la ejecución de '.$this->method,
                    'exception'    => $temporalReturn['exception']
                ]);
            }
        }else{
            $this->error = true;

            $etlState->addWarningsState([
                'localization' => 'App\Etl\Steps@validateResultExecution',
                'description'  => 'El metodo '.$this->method.' debe retornar un array iformando el estado de la ejecusion'
            ]);
        }
    }

    /**
     * @param array $params
     * @return Step
     */
    public function setParams(array $params) : Step
    {
        $this->params = $params;
        return $this;
    }

}