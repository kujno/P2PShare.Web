<?php
session_start();

header("Content-Type: application/json");

require "../DBConnection.php";

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
  header("Location: ..\index.php");
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

try {
  $db = new DBConnection();

  foreach ($data["users"] as $user) {
    $stmt = $db->PDO->prepare("UPDATE users SET space = :space, verified = :verified WHERE username = :username");
    $stmt->execute([
      ":space" => $user["space"],
      ":verified" => $user["verified"] === true ? 1 : 0,
      ":username" => $user["username"]
    ]);
  }

  echo json_encode(["success" => true]);
} catch (Exception $e) {
  echo json_encode(["error" => "Failed to update users."]);
}