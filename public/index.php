<?php
require_once __DIR__ . '/../app/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task'])) {
        addTask($_POST['task']);
    } elseif (isset($_POST['delete'])) {
        deleteTask($_POST['delete']);
    }
}

$tasks = getTasks();
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP TODO App</title>
</head>
<body>
    <h2>TODO List</h2>

    <form method="POST">
        <input type="text" name="task" placeholder="Enter Task" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        <?php while($row = $tasks->fetch_assoc()): ?>
            <li>
                <?php echo $row['task']; ?>
                <form method="POST" style="display:inline;">
                    <button name="delete" value="<?php echo $row['id']; ?>">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

</body>
</html>
