<?php
namespace App\Etl;

use App\Etl\Database\DatabaseConfig;

class Etl
{
  /**
   * $etlConfig is object for: App\Etl\EtlConfig
   * $etlConfig Initial work setup
   */
  Public $etlConfig = null;

  /**
   * $extract is object for: App\Etl\Extractors\*
   */
  Public $extract = null;

  /**
   * $extract is object for: App\Etl\Transformers\*
   */
  Public $transform = null;

  /**
   * $extract is object for: App\Etl\Loaders\*
   */
  Public $load = null;


  public static function start(String $typeProcess, int $net, int $station)
  {
    $etl = new Etl();
    $etl->etlConfig($etl, $typeProcess, $net, $station);
    return $etl;
  }


  public function etlConfig(Etl $etl, String $typeProcess, int $net, int $station)
  {
    $etl->etlConfig = new EtlConfig($typeProcess, $net, $station);
    return $etl;
  }


  public function extract(String $method)
  {
      if ($method == 'Database'){
          $this->extract = new Extractors\Database($this->etlConfig, $method);
      }else{
          $this->extract = new Extractors\Csv($this->etlConfig, $method);
      }

    return $this;
  }


  public function transform()
  {
    return $this;
  }

  public function load()
  {
    return $this;
  }

  protected function factory($class, $category, $options)
{
    if (! class_exists($class)) {
        if (isset($aliases[$category][$class])) {
            $class = $aliases[$category][$class];
        }
        $class = __NAMESPACE__ . '\\' . ucwords($category) . '\\' . $class;
    }
    $instance = new $class;
    $instance = $this->setOptions($instance, $options);
    return $instance;
}
}
