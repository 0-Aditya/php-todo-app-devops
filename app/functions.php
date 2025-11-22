<?php

require_once __DIR__ . '/../config/db.php';

function getTasks() {
    global $conn;
    $sql = "SELECT * FROM tasks ORDER BY id DESC";
    return $conn->query($sql);
}

function addTask($task) {
    global $conn;
    $task = $conn->real_escape_string($task);
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    return $conn->query($sql);
}

function deleteTask($id) {
    global $conn;
    $sql = "DELETE FROM tasks WHERE id = $id";
    return $conn->query($sql);
}
?>
