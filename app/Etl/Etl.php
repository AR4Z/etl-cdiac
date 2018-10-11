<?php

namespace App\Etl;

class Etl
{
  /**
   * $etlConfig is object for: App\Etl\EtlConfig
   * $etlConfig Initial work setup
   */
  Public $etlConfig = null;

  Public $etlObject = [];

  public $flagEtl = 0;

    /**
     * @param String $typeProcess
     * @param int $net
     * @param int $connection
     * @param int $station
     * @param bool $sequence
     * @return Etl
     */

  public static function start(String $typeProcess, $net = null,$connection = null, int $station,bool $sequence = true) : Etl
  {
      $etl = new Etl();

      # Se crea la configuración inicial del proceso.
      $etl->etlConfig($etl, $typeProcess, $net, $connection, $station, $sequence);

      return $etl;
  }


    /**
     * @param Etl $etl
     * @param String $typeProcess
     * @param int $net
     * @param int $connection
     * @param int $station
     * @param bool $sequence
     * @return Etl
     */

  public function etlConfig(Etl $etl, String $typeProcess, $net = null,$connection = null, int $station, bool $sequence) : Etl
  {
      # Se crean las configuraciones necesatias para realizar el proceso.
      $etl->etlConfig = new EtlConfig($typeProcess, $net,$connection, $station,$sequence);

      # Se evalua si se realizó la configuración.
      if (empty($this->etlConfig)) {
          dd('TODO: error no fue posible realizar las configuraciones necesarias'); # TODO: etl config not define
      }

      return $etl;
  }

    /**
     * @param String $method
     * @param array $options
     * @return $this
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
     */

  protected function factory($class, $category, $options)
  {

    if (! class_exists($class)) {
        if (isset($aliases[$category][$class])) {
            $class = $aliases[$category][$class];
        }
        $class = __NAMESPACE__ . '\\' . ucwords($category) . '\\' . $class;
    }

    $class = new $class;
    $class->setOptions($this->etlConfig);

    if (!empty($options)){
        $class = $this->setOptions($class, $options);
    }

    return $class;

  }

    /**
     * @param $class
     * @param $options
     * @return mixed
     */
    protected function setOptions($class, $options)
  {
      $refactor = new \ReflectionClass($class);
      $refactorConfig = new \ReflectionClass($this->etlConfig);
      $property = null;

      foreach ($options as $option => $value){

          if ($refactorConfig->hasProperty($option))
          {
              $property = $refactorConfig->getProperty($option);

              if ($property && $property->isPublic()){
                  $this->etlConfig->$option = $value;
              }
              if ($property && !$property->isPublic()){
                  $setOption = 'set'.$option;
                  $this->etlConfig->$setOption($value);
              }

          }else{

              if ($refactor->hasProperty($option)){
                  $property = $refactor->getProperty($option);
              }
              if ($property && $property->isPublic()){
                  $class->$option = $value;
              }
              if ($property && !$property->isPublic()){
                  $setOption = 'set'.$option;
                  $class->$setOption($value);
              }
          }

      }

      return $class;
  }

}

