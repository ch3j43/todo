<?php

namespace App;

use Exception;

/**
 * SQLite Create Table Demo
 */
class TaskService
{

  /**
   * PDO object
   * @var \PDO
   */
  private $pdo;

  /**
   * connect to the SQLite database
   */
  public function __construct() 
  {
    $this->pdo = (new Connection())->connect();
  }
    
  /**
   * Get all result
   * @param string $sql 
   * @return array
   */
  public function all(string $sort = 'created_date') 
  {
    $rows = [];
    try {
      $order = [];
      $pcs = explode(',', $sort);
      foreach ($pcs as $pc) {
        if(str_contains($pc, '-')) {
          $order[] = sprintf("%s %s", str_replace("-", '', $pc), 'DESC');
        } else {
          $order[] = sprintf("%s %s", $pc, 'ASC');
        }
      }

      $sql = sprintf('SELECT * FROM tasks ORDER BY %s', implode(', ', $order));

      $stmt = $this->pdo->query($sql);
      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $rows[] = $row;
      }
    } catch(Exception $e) {}
    return $rows;
  }

  public function getById(int $id) 
  {
    $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = :id;');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchObject();
  }

  /**
   * Create task
   * @param array $data
   */
  public function create(array $data)
  {
    $sql = 'INSERT INTO tasks(name, priority) VALUES(:name, :priority)';
    $stmt = $this->pdo->prepare($sql);
    $name = $data['name'];
    $priority = isset($data['priority']) ? $data['priority'] : 0;

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':priority', $priority);
    $stmt->execute();

    return $this->getById($this->pdo->lastInsertId());
  }

  /**
   * Update task
   * @param int $id
   * @param array $data
   */
  public function update($task, array $data)
  {
    if ($task) {
      $sql = 'UPDATE tasks SET name = :name, priority = :priority WHERE id = :id';
      $stmt = $this->pdo->prepare($sql);
      $name = $data['name'];
      $priority = isset($data['priority']) ? $data['priority'] : 0;

      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':priority', $priority);
      $stmt->bindValue(':id', $task->id);
      return $stmt->execute();
    }
    
    return false;
  }

  /**
   * Update task
   * @param array $data
   */
  public function togglePriority(int $id)
  {
    $task = $this->getById($id);
    if ($task) {
      $sql = 'UPDATE tasks SET priority = :priority WHERE id = :id';
      $stmt = $this->pdo->prepare($sql);

      $stmt->bindValue(':priority', $task->priority ? 0 : 1);
      $stmt->bindValue(':id', $id);
      
      return $stmt->execute();
    }
    return false;
  }

  /**
   * Update task
   * @param array $data
   */
  public function complete(int $id)
  {
    $task = $this->getById($id);
    if ($task) {
      $sql = 'UPDATE tasks SET completed = :completed, completed_date = :completed_date WHERE id = :id';
      $stmt = $this->pdo->prepare($sql);

      $stmt->bindValue(':completed', 1);
      $stmt->bindValue(':completed_date', date('Y-m-d H:i:s'));
      $stmt->bindValue(':id', $id);
      
      return $stmt->execute();
    }
    return false;
  }
}