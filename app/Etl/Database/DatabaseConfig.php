<?php

namespace App\Etl\Database;


use App\Repositories\Config\ConnectionRepository;
use Config;
use Log;
/**
 *
 */
class DatabaseConfig
{

  protected $connectionRepository;


  public function __construct(ConnectionRepository $connectionRepository)
  {
    $this->connectionRepository = $connectionRepository;
  }

  /**
   * Configuration external connection.
   *
   * @return Boolean
   */

  public function configExternalConnection($connectionName)
  {
    try {
      $connection =  $this->connectionRepository->getName($connectionName);
      $connection->password = decrypt($connection->password);

      Config::set("database.connections.external_connection.driver", $connection->driver);
      Config::set('database.connections.external_connection.host', $connection->host);
      Config::set('database.connections.external_connection.port', $connection->port);
      Config::set('database.connections.external_connection.database', $connection->database);
      Config::set('database.connections.external_connection.username', $connection->username);
      Config::set('database.connections.external_connection.password', $connection->password);

      return true;

    } catch (Exception $e) {
      Log::info('Fallo en la conexión.');
      return false;
    }
  }
}
