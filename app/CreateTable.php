<?php

namespace App;

/**
 * SQLite Create Table Demo
 */
class CreateTable 
{

  /**
   * PDO object
   * @var \PDO
   */
  private $pdo = null;

  /**
   * connect to the SQLite database
   */
  public function __construct() 
  {
    $this->pdo = (new Connection())->connect();
  }
    
  /**
   * create tasks table
   */
  public function createTaskTable() 
  {
    $commands = [
      "DROP TABLE IF EXISTS tasks;",
      "CREATE TABLE tasks (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      name  VARCHAR (255) NOT NULL,
      completed  INTEGER NOT NULL DEFAULT 0,
      priority  INTEGER NOT NULL DEFAULT 0,
      completed_date TIMESTAMP,
      created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"];

    foreach($commands as $command) {
      $this->pdo->exec($command);
    }
  }
}