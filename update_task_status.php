<?php
require_once 'includes/auth.php';
require_once 'includes/tasks.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && isset($_POST['status'])) {
    $task_id = (int)$_POST['task_id'];
    $status = $_POST['status'] === 'completed' ? 'completed' : 'pending';
    
    if (isAdmin()) {
        // Admins can update status of any task
        $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $success = $stmt->execute([$status, $task_id]);
    } else {
        // Regular users can only update their own tasks
        $success = updateTaskStatus($task_id, $_SESSION['user_id'], $status);
    }
    
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
?>