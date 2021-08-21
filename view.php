<?php
session_start();
require 'vendor/autoload.php';

use App\TaskService;
$taskService = new TaskService();

/**
 * get task
 */
$task = $taskService->getById($_GET['id']);
if (!$task) header('Location: /');

$csrf = uniqid();
$_SESSION['csrf'] = $csrf;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Todo</title>
    <link href="/assets/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    <div class="container view">
      <div class="page-header">
        <h1>Task detail</h1>
      </div>
      <table class="table table-bordered">
          <tr>
            <th>name</th>
            <td><?php echo $task->name ?></td>
          </tr>
          <tr>
            <th>priority</th>
            <td class="text-primary">
              <i class="fa fa-<?php echo $task->priority ? 'check-square' : 'square' ?>"></i>
            </td>
          </tr>
          <tr>
            <th>completed</th>
            <td class="text-primary">
              <i class="fa fa-<?php echo $task->completed ? 'check-square' : 'square' ?>"></i>
            </td>
          </tr>
          <tr>
            <th>completed at</th>
            <td>
              <?php echo $task->completed_date ?>
            </td>
          </tr>
          <tr>
            <th>created at</th>
            <td><?php echo $task->created_date ?></td>
          </tr>
          <tr>
            <th></th>
            <td>
              <a class="btn btn-primary" href="/">Back</a>
              <?php if (!$task->completed): ?>
              <a class="btn btn-primary" href="/edit.php?id=<?php echo $task->id ?>&csrf=<?php echo $csrf ?>">Edit</a>\
              <a class="btn btn-primary" href="/complete.php?id=<?php echo $task->id ?>&csrf=<?php echo $csrf ?>">Complete</a>
              <?php endif ?>
            </td>
          </tr>
      </table>
    </div>
    <script src="/assets/js/index.js"></script>
  </body>
</html>