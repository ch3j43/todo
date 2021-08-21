<?php
session_start();
require 'vendor/autoload.php';

use App\TaskService;

if ($_POST && $_POST['name'] != '') {
  if (!isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf']) {
    http_response_code(404);
    exit;
  }
  $taskService = new TaskService();
  $taskService->create($_POST);
  header('Location: /');
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
        <h1>New task</h1>
      </div>
      <form method="POST">
        <input type="hidden" name="csrf" value="<?php echo $csrf ?>" />
        <table class="table table-bordered">
            <tr>
              <th>name*</th>
              <td><input class="form-control" type="text" name="name" /></td>
            </tr>
            <tr>
              <th>priority</th>
              <td><input class="form-check-input" type="checkbox" name="priority" value="1" /></td>
            </tr>
            <tr>
              <th><button class="btn btn-danger" type="button" onclick="location.href='/'">Cancel</button></th>
              <td><button class="btn btn-primary" type="submit">Create</button></td>
            </tr>
        </table>
      </form>
    </div>
    <script src="/assets/js/index.js"></script>
  </body>
</html>