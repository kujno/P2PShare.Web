<?php

session_start();

header("Content-Type: application/json");

require "../DBConnection.php";

if (!isset($_SESSION['loggedIn'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

try {
    $db = new DBConnection();

    $stmt = $db->PDO->query("
        SELECT username, name, surename, verified, space 
        FROM users
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "users" => $users]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}