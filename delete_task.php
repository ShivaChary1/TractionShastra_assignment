<?php
require_once 'includes/auth.php';
require_once 'includes/tasks.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];
    if (isAdmin()) {
        deleteTask($task_id);
    } else {
        deleteTask($task_id, $_SESSION['user_id']);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
