<?php
session_start();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>P2PShare Admin Panel</title>
</head>
<body>
  <div>

  </div>
</body>
</html>