<?php
require_once 'includes/auth.php';
require_once 'includes/tasks.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];
    if (isAdmin()) {
        // Admins can delete any task
        $success = deleteTask($task_id);
    } else {
        // Regular users can only delete their own tasks
        $success = deleteTask($task_id, $_SESSION['user_id']);
    }
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
?>