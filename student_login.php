<?php
session_start();
require "db.php";

$message = "";

if (isset($_POST["btn_login"])) {
  $username = trim($_POST["username"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if ($username === "" || $password === "") {
    $message = "Please enter both username and password.";
  } else {
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user["password_hash"])) {
      $_SESSION["logged_in"] = true;
      $_SESSION["username"] = $user["username"];
      header("Location: index.php");
      exit();
    } else {
      $message = "Invalid credentials.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Login</title>
  <link rel="stylesheet" href="Style/style.css">
</head>
<body>
  <div class="container">
    <div class="panel">
      <h2 class="center">Welcome to Student Management System</h2>
      

      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" autocomplete="off">

        <label>Password</label>
        <input type="password" name="password">

        <div class="row" style="justify-content:center;">
          <button class="btn" type="submit" name="btn_login">Login →</button>
        </div>

        <?php if ($message !== ""): ?>
          <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
      </form>
    </div>
  </div>
</body>
</html>