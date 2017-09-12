<?php

namespace App\Etl\Database;

use Facades\App\Repositories\Administrator\ConnectionRepository;
use Config;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;
/**
 *
 */
trait DatabaseConfig
{

    /**
     * @param $connection
     * @param $extractTable
     * @return bool
     */
    public function searchExternalConnection($connection, $extractTable)
    {
        $var = $this->configExternalConnection($connection);
        if ($var){
            if ($this->validateExistenceExternalTable($extractTable)){return true;}
        }
        return $this->loopForConnection($connection->id,$extractTable);
    }

    /**
     * @param $connectionId
     * @param $extractTable
     * @return bool
     */
    private function loopForConnection($connectionId, $extractTable)
    {
        $connections = ConnectionRepository::getStationsNotIn([$connectionId,1]);
        $i = 0;
        $flag = false;
        $limit = count($connections);
        while ($i < $limit and !$flag){
            $var = $this->configExternalConnection($connections[$i]);
            if ($var){
                $flag = $this->validateExistenceExternalTable($extractTable);
            }
            $i++;
        }

        return $flag;
    }

    /**
     * @param string $extractTable
     * @return bool
     */
    private function validateExistenceExternalTable(string $extractTable)
    {
        $tables = DB::connection('external_connection')->select('SHOW TABLES');
        $arr= [];
        foreach ($tables as $table){array_push($arr,array_values((array)$table)[0]);}

        return (! array_search($extractTable,$arr) == false);
    }
    /**
     * Configuration external connection.
     *
     * @param $connection
     * @return bool
     */

  private function configExternalConnection($connection)
  {
      if ($connection->id == 1){
          return false;
      }
      if (!$connection->etl_active){
            // TODO.. Excepcion por no estar activa la conección.
          Log::info('Coneccion desabilidata para el proceso de etl');
          return false;
      }
    try {
      $connection->password = decrypt($connection->password);
      Config::set("database.connections.external_connection.driver", $connection->connection_driver);
      Config::set('database.connections.external_connection.host', $connection->host);
      Config::set('database.connections.external_connection.port', $connection->port);
      Config::set('database.connections.external_connection.database', $connection->database);
      Config::set('database.connections.external_connection.username', $connection->username);
      Config::set('database.connections.external_connection.password', $connection->password);

      //dd(Config::get('database.connections.external_connection'));
      return true;

    } catch (Exception $e) {
      Log::info('Fallo en la conexión.');
      return false;
    }
  }
}
