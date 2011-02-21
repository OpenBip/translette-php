<?php

require_once( dirname(__FILE__) . '/MySQL.php' );

class SiteConfiguration {
  /** @var string Used for database-backed data sources */
  const DATABASE_HOST = 'host';
  /** @var string Used for database-backed data sources */
  const DATABASE_USERNAME = 'username';
  /** @var string Used for database-backed data sources */
  const DATABASE_PASSWORD = 'password';
  /** @var string The name of the database; for database-backed data sources */
  const DATABASE_DATABASE = 'database';

  public $mysql;

  public function __construct($configFilePath) {
    date_default_timezone_set('America/Detroit');

    $xml = simplexml_load_file($configFilePath);

    $database = $xml->database;
    $this->mysql = new MySQL(
        (string) $database[self::DATABASE_HOST],
        (string) $database[self::DATABASE_USERNAME],
        (string) $database[self::DATABASE_PASSWORD],
        (string) $database[self::DATABASE_DATABASE]);
  }
}

$lemast_config = new SiteConfiguration(dirname(__FILE__)
    . "/../../../../../siteconf/final-configuration.xml");