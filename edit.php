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

if ($_POST && $_POST['name'] != '') {
  if (!isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf']) {
    http_response_code(404);
    exit;
  }
  
  $taskService->update($task, $_POST);
  header('Location: /view.php?id=' .  $task->id);
}
/**
 * form validation
 */
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
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>Edit task</h1>
      </div>
      <form method="POST">
        <input type="hidden" name="csrf" value="<?php echo $csrf ?>" />
        <input type="hidden" name="id" value="<?php echo $task->id ?>" />
        <table class="table table-bordered">
            <tr>
              <th>name*</th>
              <td><input class="form-control" type="text" name="name" value="<?php echo $task->name ?>" /></td>
            </tr>
            <tr>
              <th>priority</th>
              <td><input class="form-check-input" type="checkbox" name="priority" value="1" <?php echo $task->priority ? 'checked' : '' ?> /></td>
            </tr>
            <tr>
              <th><a class="btn btn-danger" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Cancel</a></th>
              <td><button class="btn btn-primary" type="submit">Update</button></td>
            </tr>
        </table>
      </form>
    </div>
    <script src="/assets/js/index.js"></script>
  </body>
</html>