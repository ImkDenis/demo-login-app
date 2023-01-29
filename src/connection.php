<?php
/**
 * @package Demo application
 *
 * @author Kaslik Denisz
 *
 */

include('../config/config.php');

const GEN_ERROR = "General Error: Database connection failed.<br>";

class Connection
{

  private $conn;
  private $dbHost = DB_HOST;
  private $dbName = DB_NAME;
  private $dbUser = DB_USER;
  private $dbPass = DB_PASS;

  function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPass);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
      echo GEN_ERROR . $ex->getMessage();
    }
  }

  function returnConnection()
  {
    return $this->conn;
  }
}