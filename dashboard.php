<?php
require_once 'includes/header.php';
require_once 'includes/tasks.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];
    $task_id = isset($_POST['task_id']) ? (int)$_POST['task_id'] : null;

    if ($_POST['action'] === 'create') {
        createTask($_SESSION['user_id'], $title, $deadline, $priority);
    } elseif ($_POST['action'] === 'update' && $task_id) {
        updateTask($task_id, $_SESSION['user_id'], $title, $deadline, $priority);
    }
    header('Location: dashboard.php');
    exit;
}

$tasks = getUserTasks($_SESSION['user_id']);
?>
<h2>Your Tasks</h2>
<form id="taskForm" class="mb-4">
    <input type="hidden" id="taskId" name="task_id">
    <input type="hidden" id="action" name="action" value="create">
    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="deadline" class="form-label">Deadline</label>
        <input type="date" class="form-control" id="deadline" name="deadline" required>
    </div>
    <div class="mb-3">
        <label for="priority" class="form-label">Priority</label>
        <select class="form-control" id="priority" name="priority" required>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" id="submitBtn">Add Task</button>
</form>

<div class="mb-3">
    <label for="filterPriority" class="form-label">Filter by Priority</label>
    <select class="form-control" id="filterPriority">
        <option value="">All</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
    </select>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Deadline</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="taskTable">
        <?php foreach ($tasks as $task): ?>
            <tr data-priority="<?php echo htmlspecialchars($task['priority']); ?>">
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <button class="btn btn-sm btn-warning editTask" data-id="<?php echo $task['id']; ?>" data-title="<?php echo htmlspecialchars($task['title']); ?>" data-deadline="<?php echo $task['deadline']; ?>" data-priority="<?php echo $task['priority']; ?>">Edit</button>
                    <button class="btn btn-sm btn-danger deleteTask" data-id="<?php echo $task['id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
