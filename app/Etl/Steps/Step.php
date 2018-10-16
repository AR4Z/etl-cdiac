<?php

namespace App\Etl\Steps;

use App\Etl\EtlState;
use Exception;
use function Symfony\Component\Debug\Tests\testHeader;

class Step
{
    /**
     * @var string
     */
    private $method = '';

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var bool
     */
    private $requireParams = false;

    /**
     * @var bool
     */
    private $terminate = false;

    /**
     * @var bool
     */
    private $inProcess = false;

    /**
     * @var array
     */
    private $return = null;

    /**
     * @var bool
     */
    private $requireReturn = false;

    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var EtlState
     */
    private $etlState;

    /**
     * Step constructor.
     * @param EtlState $etlState
     * @param string $method
     */
    public function __construct(EtlState $etlState,string $method = '')
    {
        $this->etlState = $etlState;
        $this->setMethod($method);
    }

    public function start($process)
    {
        $this->inProcess = true;

        $resultExecute = $this->executeStep($process);

        $this->validateResultExecution($resultExecute);

        $validate = $this->validateReturn();

        if (!$validate and true){ dd($this,'TODO ESTO DEBE SER SI SE PUEDEN VISUALIZAR LOS ERRORES');}
        #TODO ESTO DEBE SER SI SE PUEDEN VISUALIZAR LOS ERRORES
        #TODO en que momento detener el proceso ??????

        $this->inProcess = false;
        $this->terminate = true;

        return ($validate) ? $this->return : null;
    }

    /**
     * @return bool
     */
    public function validateReturn() : bool
    {
        if ($this->error){ return false;}

        if ($this->requireReturn) {
            if (is_null($this->return)){
                $this->error = true;
                $this->etlState->addErrorsState([
                    'localization' => 'App\Etl\Steps@validateReturn',
                    'description' => 'Es obligatorio retorar un valor para '.$this->method.' y no se esta retornando'
                ]);

                return false;
            }
        }

        return true;
    }

    /**
     * @param $process
     * @return null
     */
    public function executeStep($process)
    {
        $temporalReturn = null;

        if ($this->requireParams){
            if (count($this->params) > 0){
                $temporalReturn = $process->{$this->method}($this->params);
            }else{
                $this->error = true;

                $this->etlState->addErrorsState([
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
     * @param array $temporalReturn
     */
    public function validateResultExecution(array $temporalReturn = [])
    {
        if (count($temporalReturn) > 0){
            if ($temporalReturn['resultExecution']){

                $this->return = $temporalReturn['data'];

                $this->etlState->addInfoState([
                    'localization' => 'App\Etl\Steps@validateResultExecution',
                    'description'  => 'terminado el paso '.$this->method
                ]);

            }else{
                $this->error = true;

                $this->etlState->addWarningsState([
                    'localization' => 'App\Etl\Steps@validateResultExecution',
                    'description'  => 'Hubo un error en la ejecusion de '.$this->method,
                    'exception'    => $temporalReturn['exception']
                ]);
            }
        }else{
            $this->error = true;

            $this->etlState->addWarningsState([
                'localization' => 'App\Etl\Steps@validateResultExecution',
                'description'  => 'El metodo '.$this->method.' debe retornar un array iformando el estado de la ejecusion'
            ]);
        }
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
     * @return Step
     */
    public function setMethod(string $method) : Step
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
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

    /**
     * @return bool
     */
    public function isTerminate(): bool
    {
        return $this->terminate;
    }

    /**
     * @param bool $terminate
     * @return Step
     */
    public function setTerminate(bool $terminate) : Step
    {
        $this->terminate = $terminate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInProcess(): bool
    {
        return $this->inProcess;
    }

    /**
     * @param bool $process
     * @return Step
     */
    public function setInProcess(bool $process) : Step
    {
        $this->inProcess = $process;
        return $this;
    }

    /**
     * @return null
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param null $return
     * @return Step
     */
    public function setReturn($return) : Step
    {
        $this->return = $return;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireParams(): bool
    {
        return $this->requireParams;
    }

    /**
     * @param bool $requireParams
     * @return Step
     */
    public function setRequireParams(bool $requireParams) : Step
    {
        $this->requireParams = $requireParams;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireReturn(): bool
    {
        return $this->requireReturn;
    }

    /**
     * @param bool $requireReturn
     * @return Step
     */
    public function setRequireReturn(bool $requireReturn) : Step
    {
        $this->requireReturn = $requireReturn;
        return $this;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     * @return Step
     */
    public function setError(bool $error) : Step
    {
        $this->error = $error;
        return $this;
    }


}