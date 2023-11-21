<?php
require_once 'database.php';

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM `goscie` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $stmt = $conn->prepare("UPDATE `goscie` SET name = ?, email = ?, message = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $message, $id);
    $stmt->execute();

    header("Location: ./index.php");
}

$stmt->close();
$conn->close();
?>