<?php

$host = "172.31.34.64";   // Example: 172.31.34.64
$user = "todo_user";
$pass = "todo123";
$dbname = "todo_app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
