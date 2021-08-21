<?php
require 'vendor/autoload.php';

use App\CreateTable;

$createTable = new CreateTable();
$createTable->createTaskTable();
header('Location: /');