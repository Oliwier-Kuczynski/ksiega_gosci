<?php
require_once 'database.php';

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_GET["id"];
    $sql = "DELETE FROM `goscie` WHERE `id` = $id";
    $result = $conn->query($sql);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $sql = "UPDATE `goscie` SET name = '$name', email = '$email', message = '$message' WHERE id = $id";
    $result = $conn->query($sql);

    header("Location: ./index.php");
}
?>