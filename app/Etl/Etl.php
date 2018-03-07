<?php
namespace App\Etl;

use App\Jobs\EtlStationJob;


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

  public static function start(String $typeProcess, $net = null,$connection = null, int $station,bool $sequence = true)
  {
    $etl = new Etl();
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

  public function etlConfig(Etl $etl, String $typeProcess, $net,$connection, int $station, bool $sequence)
  {
    $etl->etlConfig = new EtlConfig($typeProcess, $net,$connection, $station,$sequence);
    return $etl;
  }

    /**
     * @param String $method
     * @param array $options
     * @return $this
     */

  public function extract(string $method = 'Database', $options = [])
  {
      if (!empty($this->etlConfig)) {
            //etl config not define TODO
      }

      array_push($this->etlObject,$this->factory($method,'Extractors',$options));
      $this->flagEtl++;

      return $this;
  }

    /**
     * @param string $method
     * @param array $options
     * @return $this
     */
    public function transform(string $method = 'Original', $options = [])
  {
      array_push($this->etlObject,$this->factory($method,'Transformers',$options));
      $this->flagEtl++;

      return $this;
  }

    /**
     * @param string $method
     * @param array $options
     * @return $this
     */

  public function load(string $method = 'Load', $options = [])
  {
      array_push($this->etlObject,$this->factory($method, 'Loaders',$options));
      $this->flagEtl++;
      //$this->reloadPrecess();

      return $this;
  }

  public function run(){
        foreach ($this->etlObject as $object){
            $object->run();
        }
        return $this;
  }

    /**
     *
     */
    public function reloadPrecess()
  {
      if (
          $this->etlConfig->getSequence() and
          !($this->etlConfig->getStation()->{$this->etlConfig->getStateTable()}->it_update)
      )
      {
          dispatch(
              new EtlStationJob(
                  $this->etlConfig->getTypeProcess(),
                  $this->etlConfig->getNet()->id,
                  $this->etlConfig->getStation()->id,
                  $this->etlConfig->getSequence()
              )
          );
      }
      return;
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

