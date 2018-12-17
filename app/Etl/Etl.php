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
     * @var EtlFactoryContract[]
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

        $this->setOptions($this->etlConfig,$options);

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
        array_push($this->etlObject,$this->factory($method,'Extractors',true,$options));

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
        array_push($this->etlObject,$this->factory($method,'Transformers',true,$options));

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
        array_push($this->etlObject,$this->factory($method, 'Loaders',true,$options));

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
    public function run($method = 'RunSynchronous',$options = []) : Etl
    {
        # Se evalua que los procesos anteriores no conengan errores fatales.
        if ($this->etlConfig->processState->stopProcessState){
            dd('TODO: error no fue posible realizar las configuraciones necesarias. Etl.php method run'); # TODO
        }

        $options['eltProcess'] = $this->etlObject;

        $executor = $this->factory($method, 'Run',false,$options);

        $executor->execute();

        return $this;
    }

    /**
     * @param string $class
     * @param string $category
     * @param bool $config
     * @param array $options
     * @return mixed
     * @throws \ReflectionException
     */

    protected function factory(string $class, string $category, bool $config = true, array $options = [])
    {
        # Se crea la direccion completa de la clase
        if (! class_exists($class)) {$class = __NAMESPACE__ . '\\' . ucwords($category) . '\\' . $class;}

        # Se crea un objeto de la clase en cuestion
        $class = new $class;

        # Se agrega la configuracion global en caso de ser requerida
        if ($config){ $options['etlConfig'] = $this->etlConfig;}

        # Se agrega la configuracion ingresada externamente
        if (!empty($options) and !is_null($class)){ $this->setOptions($class, $options); }

        return $class;
    }

    /**
     * @param $class
     * @param $options
     * @return null
     * @throws \ReflectionException
     * @throws \Exception
     */

    protected function setOptions($class, array $options = [])
    {
        $reflectionClass = new ReflectionClass($class);
        $reflectionConfig = new ReflectionClass($this->etlConfig);

        foreach ($options as $option => $value) {
            $result = $this->setOption($reflectionConfig,$reflectionClass,$method = 'set'.$option,$value);

            if (!$result){
                $this->etlConfig->processState->addWarningsState([
                    'localization'  => 'App\Etl@setOptions',
                    'description'   => 'Un metodo para ingresar la propiedad : set'.$option.', por lo tanto esta propiedad no se utilizó en el proceso',
                ]);
            }
        }
    }

    /**
     * @param ReflectionClass $reflectionConfig
     * @param ReflectionClass $reflectionClass
     * @param string $method
     * @param $value
     * @return bool
     */
    protected function setOption(ReflectionClass $reflectionConfig, ReflectionClass $reflectionClass, string $method, $value) : bool
    {
        if ($this->validateMethodExistence($reflectionConfig,$method)) {
            $this->toAssignValueFromMethodClass($reflectionConfig, $method, $value);
            return true;
        }

        if ($this->validateMethodExistence($reflectionClass,$method)){
            $this->toAssignValueFromMethodClass($reflectionClass, $method, $value);
            return true;
        }

        return false;
    }

    /**
     * @param ReflectionClass $reflector
     * @param $method
     * @return bool
     */
    protected function validateMethodExistence(ReflectionClass $reflector, $method) : bool
    {
        return ($reflector->hasMethod($method));
    }

    /**
     * @param $class
     * @param string $method
     * @param $value
     * @return mixed
     */
    protected function toAssignValueFromMethodClass($class, string $method, $value)
    {
        return $class->$method($value);
    }

}

