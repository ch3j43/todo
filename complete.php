<?php
session_start();
require 'vendor/autoload.php';

if (!isset($_GET['csrf']) || $_GET['csrf'] != $_SESSION['csrf']) {
  http_response_code(404);
  exit;
}

use App\TaskService;
$taskService = new TaskService();

/**
 * get task
 */
$task = $taskService->getById($_GET['id']);
if (!$task) header('Location: /');

$taskService->complete($task->id);
header('Location: /view.php?id=' .  $task->id);
?>