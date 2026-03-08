<?php

session_start();

header("Content-Type: application/json");

require "../DBConnection.php";

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
  header("Location: ..\index.php");
  exit;
}

try {
    $db = new DBConnection();

    $stmt = $db->PDO->query("
        SELECT username, name, surename, verified, space 
        FROM users
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $users = array_filter($users, function($user) {
        return $user["username"] !== "admin";
    });

    usort($users, function($a, $b) {
        return $a["username"] <=> $b["username"];
    });

    echo json_encode(["users" => $users]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}