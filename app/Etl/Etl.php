<?php

namespace App\Etl;

use ReflectionClass;

class Etl
{
    /**
     * @var EtlConfig
     */
    Public $etlConfig = null;

    /**
     * @var array
     */
    Public $etlObject = [];

    /**
     * @var int
     */
    public $flagEtl = 0;

    /**
     * @param String $typeProcess
     * @param int $net
     * @param int $connection
     * @param int $station
     * @param array $options
     * @return Etl
     * @throws \ReflectionException
     */

    public static function start(String $typeProcess, $net = null,$connection = null, int $station,array $options = []) : Etl
    {
        $etl = new Etl();

        # Se crea la configuración inicial del proceso.
        $etl->etlConfig($etl, $typeProcess, $net, $connection, $station, $options);

        return $etl;
    }


    /**
     * @param Etl $etl
     * @param String $typeProcess
     * @param int $net
     * @param int $connection
     * @param int $station
     * @param array $options
     * @return Etl
     * @throws \ReflectionException
     */

    public function etlConfig(Etl $etl, String $typeProcess, $net = null,$connection = null, int $station, array $options = []) : Etl
    {
        # Se crean las configuraciones necesatias para realizar el proceso.
        $etl->etlConfig = new EtlConfig($typeProcess, $net,$connection, $station);

        # Se evalua si se realizó la configuración.
        if (empty($this->etlConfig)) {
            dd('TODO: error no fue posible realizar las configuraciones necesarias'); # TODO: etl config not define
        }

        $this->setOptions(null,$options);

        return $etl;
    }

    /**
     * @param String $method
     * @param array $options
     * @return $this
     * @throws \ReflectionException
     */

    public function extract(string $method = 'Database', $options = []) : Etl
    {
        # Se evalua que los procesos anteriores no conengan errores fatales.
        if ($this->etlConfig->processState->stopProcessState){
            dd('TODO: error no fue posible realizar las configuraciones necesarias. Etl.php method extract'); # TODO
        }

        # Se ingrega el metodo de extracción en el array de ejecusión.
        array_push($this->etlObject,$this->factory($method,'Extractors',$options));

        # Se aumenta el contados de procesos a ejecutar.
        $this->flagEtl++;

        return $this;
    }

    /**
     * @param string $method
     * @param array $options
     * @return $this
     * @throws \ReflectionException
     */
    public function transform(string $method = 'Original', $options = []) : Etl
    {
        # Se evalua que los procesos anteriores no conengan errores fatales.
        if ($this->etlConfig->processState->stopProcessState){
            dd('TODO: error no fue posible realizar las configuraciones necesarias. Etl.php method transform'); # TODO
        }

        # Se ingrega el metodo de extracción en el array de ejecusión.
        array_push($this->etlObject,$this->factory($method,'Transformers',$options));

        # Se aumenta el contados de procesos a ejecutar.
        $this->flagEtl++;

        return $this;
    }

    /**
     * @param string $method
     * @param array $options
     * @return $this
     * @throws \ReflectionException
     */

    public function load(string $method = 'Load', $options = []) : Etl
    {
        # Se evalua que los procesos anteriores no conengan errores fatales.
        if ($this->etlConfig->processState->stopProcessState){
            dd('TODO: error no fue posible realizar las configuraciones necesarias. Etl.php method load'); # TODO
        }

        # Se ingrega el metodo de extracción en el array de ejecusión.
        array_push($this->etlObject,$this->factory($method, 'Loaders',$options));

        # Se aumenta el contados de procesos a ejecutar.
        $this->flagEtl++;

        return $this;
    }

    /**
     * @return $this
     */
    public function run() : Etl
    {
        # Se evalua que los procesos anteriores no conengan errores fatales.
        if ($this->etlConfig->processState->stopProcessState){
            dd('TODO: error no fue posible realizar las configuraciones necesarias. Etl.php method run'); # TODO
        }

        # Se ejecuta cada una de los metodos run detro de los procesos en cola de ejecusión.
        foreach ($this->etlObject as $object){$object->run();}

        return $this;
    }

    /**
     * @param $class
     * @param $category
     * @param $options
     * @return mixed
     * @throws \ReflectionException
     */

    protected function factory($class, $category, $options)
    {
        if (! class_exists($class)) {
            $class = __NAMESPACE__ . '\\' . ucwords($category) . '\\' . $class;
        }

        $class = new $class;
        $class->setOptions($this->etlConfig);

        if (!empty($options)){ $this->setOptions($class, $options); }

        return $class;
    }

    /**
     * @param $class
     * @param $options
     * @return null
     * @throws \ReflectionException
     * @throws \Exception
     */

    protected function setOptions($class = null, array $options = [])
    {
        $refactor = (!is_null($class)) ? new ReflectionClass($class) : $class;
        $refactorConfig = new ReflectionClass($this->etlConfig);

        foreach ($options as $option => $value)
        {
            $setMethod = 'set'.$option;

            if ($refactorConfig->hasMethod($setMethod)) {
                $this->etlConfig->$setMethod($value);

            }elseif (!is_null($refactor)) {
                if ($refactor->hasMethod($setMethod)) { $class->$setMethod($value); }
            }else{
                $this->etlConfig->processState->addWarningsState([
                    'localization'  => 'App\Etl@setOptions',
                    'description'   => 'Un metodo para ingresar la propiedad : '.$option.', por lo tanto esta propiedad no se utilizó en el proceso',
                ]);
            }
        }
    }

}

