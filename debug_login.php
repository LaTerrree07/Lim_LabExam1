<?php
// debug_login.php (TEMP ONLY)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";

echo "<h3>DB Debug</h3>";

// Show what database PHP is using
$dbRes = mysqli_query($conn, "SELECT DATABASE() AS db");
$dbRow = mysqli_fetch_assoc($dbRes);
echo "Connected database: <b>" . htmlspecialchars($dbRow["db"] ?? "NONE") . "</b><br><br>";

// Check if admin exists
$sql = "SELECT id, username, password_hash FROM users WHERE username = 'admin' LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res) {
  echo "Query error: " . mysqli_error($conn);
  exit();
}

$user = mysqli_fetch_assoc($res);

echo "<pre>";
var_dump($user);
echo "</pre>";

if ($user) {
  echo "<br>Hash starts with: <b>" . substr($user["password_hash"], 0, 4) . "</b><br>";
  echo "password_verify('admin123', hash) result: <b>";
  var_dump(password_verify("admin123", $user["password_hash"]));
  echo "</b>";
}
?>