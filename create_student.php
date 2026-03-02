<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
  header("Location: student_login.php");
  exit();
}

require "db.php";
require "StudentManager.php";

$sm = new StudentManager($conn);

$error = "";

if (isset($_POST["btn_add"])) {
  $idNumber = trim($_POST["id_number"] ?? "");
  $fullName = trim($_POST["full_name"] ?? "");
  $email    = trim($_POST["email"] ?? "");
  $course   = trim($_POST["course"] ?? "");

  if ($idNumber === "" || $fullName === "" || $email === "" || $course === "") {
    $error = "All fields are required.";
  } else {
    $sm->createStudent($idNumber, $fullName, $email, $course);
    header("Location: index.php?msg=added");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Student Record</title>
  <link rel="stylesheet" href="Style/style.css">
</head>
<body>
  <div class="container">
    <h1>Create Student Record</h1>

    <form method="POST">
      <label>ID Number</label>
      <input type="text" name="id_number" value="<?php echo htmlspecialchars($_POST["id_number"] ?? ""); ?>">

      <label>Name</label>
      <input type="text" name="full_name" value="<?php echo htmlspecialchars($_POST["full_name"] ?? ""); ?>">

      <label>Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($_POST["email"] ?? ""); ?>">

      <label>Course</label>
      <input type="text" name="course" value="<?php echo htmlspecialchars($_POST["course"] ?? ""); ?>">

      <div class="row">
        <button class="btn" type="submit" name="btn_add">Add Student →</button>
        <a class="link" href="index.php">Cancel</a>
      </div>

      <?php if ($error !== ""): ?>
        <div class="alert"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>