<?php

session_start();

require "..\DBConnection.php";
require "..\Hasher.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"] ?? "";
$password = $data["password"] ?? "";

if (!$username || !$password) {
  echo json_encode(["success" => false]);
  exit;
}

if ($username !== "admin") {
  echo json_encode(["success" => false]);
  exit;
}

try{
  $dbConnection = new DBConnection();
}
catch (PDOException $e) {
  echo json_encode(["error" => "Database connection failed."]);
  exit;
}

$stmt = $dbConnection->PDO->query("SELECT password_hash FROM users WHERE username = \"admin\"");

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (Hasher::Verify($password, $result["password_hash"])){
  $_SESSION["loggedIn"] = true;  

echo json_encode(["success" => true]);
}
else {
  echo json_encode(["success" => false]);
}