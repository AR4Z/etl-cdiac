<?php

namespace App\Etl\Database;

use Config;
use Exception;
use Log;
/**
 *
 */
trait DatabaseConfig
{
    /**
     * Configuration external connection.
     *
     * @param $connection
     * @return bool
     */

  public function configExternalConnection($connection)
  {
    try {

      $connection->password = decrypt($connection->password);

      Config::set("database.connections.external_connection.driver", $connection->driver);
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
