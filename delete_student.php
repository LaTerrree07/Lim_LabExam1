<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
  header("Location: student_login.php");
  exit();
}

require "db.php";
require "StudentManager.php";

$sm = new StudentManager($conn);

$id = (int)($_GET["id"] ?? 0);
if ($id > 0) {
  $sm->deleteStudent($id);
}

header("Location: index.php?msg=deleted");
exit();