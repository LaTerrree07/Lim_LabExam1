<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
  header("Location: student_login.php");
  exit();
}

require "db.php";
require "StudentManager.php";

$sm = new StudentManager($conn);

$notice = "";
$msg = $_GET["msg"] ?? "";
if ($msg === "added")   $notice = "Student added successfully.";
if ($msg === "updated") $notice = "Student updated successfully.";
if ($msg === "deleted") $notice = "Student deleted successfully.";

$students = $sm->getAllStudents();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Records</title>
  <link rel="stylesheet" href="Style/style.css">
</head>
<body>
  <div class="container">
    <div class="topbar">
      <a class="btn" href="student_logout.php">Logout</a>
    </div>

    <h1 class="center">Student Records</h1>

    <a class="btn full-btn" href="create_student.php">Add Student +</a>

    <?php if ($notice !== ""): ?>
      <div class="alert"><?php echo htmlspecialchars($notice); ?></div>
    <?php endif; ?>

    <div class="cards">
      <?php while ($row = $students->fetch_assoc()): ?>
        <div class="card">
          <div class="menu">
            <button class="menu-btn" type="button">⋯</button>
            <div class="dropdown">
              <a href="edit_student.php?id=<?php echo (int)$row["id"]; ?>">✏️ Edit</a>
              <a href="delete_student.php?id=<?php echo (int)$row["id"]; ?>"
                 onclick="return confirm('Delete this student record?');">🗑️ Delete</a>
            </div>
          </div>

          <div class="name"><?php echo htmlspecialchars($row["full_name"]); ?></div>
          <div class="meta">
            <?php echo htmlspecialchars($row["email"]); ?><br>
            <?php echo htmlspecialchars($row["id_number"]); ?><br>
            <?php echo htmlspecialchars($row["course"]); ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>