
<?php
require_once '../config/db_connect.php';

function createTask($user_id, $title, $deadline, $priority) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, deadline, priority, status) VALUES (?, ?, ?, ?, 'pending')");
    return $stmt->execute([$user_id, $title, $deadline, $priority]);
}

function getUserTasks($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTasks() {
    global $pdo;
    $stmt = $pdo->query("SELECT t.*, u.name FROM tasks t JOIN users u ON t.user_id = u.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateTask($task_id, $user_id, $title, $deadline, $priority) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, deadline = ?, priority = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$title, $deadline, $priority, $task_id, $user_id]);
}

function deleteTask($task_id, $user_id = null) {
    global $pdo;
    if ($user_id) {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        return $stmt->execute([$task_id, $user_id]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$task_id]);
    }
}
?>
