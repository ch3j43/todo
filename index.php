

<?php
require 'vendor/autoload.php';

use App\TaskService;

$taskService = new TaskService();
$tasks = $taskService->all();
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
    <div class="container">
      <div class="page-header">
        <h1>
          Tasks
          <a href="new.php" class="text-primary">
            <i class="fa fa-plus-square"></i>
          </a>
        </h1>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>name</th>
            <th>priority</th>
            <th>completed</th>
            <th>created date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) : ?>
          <tr>
            <td><?php echo $task['name'] ?></td>
            <td class="text-primary text-center">
              <i class="fa fa-<?php echo $task['priority'] ? 'check-square' : 'square' ?>"></i>
            </td>
            <td class="text-primary text-center">
             <i class="fa fa-<?php echo $task['completed'] ? 'check-square' : 'square' ?>"></i>
            </td>
            <td class="text-center">
              <?php echo $task['created_date'] ?>
            </td>
            <td>
              <a href="/view.php?id=<?php echo $task['id'] ?>" class="text-primary">
                <i class="fa fa-external-link-alt"></i>
              </a>
              <?php if (!$task['completed']): ?>
                <a href="/edit.php?id=<?php echo $task['id'] ?>" class="text-primary">
                  <i class="fa fa-edit"></i>
                </a>
              <?php endif ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </body>
</html>