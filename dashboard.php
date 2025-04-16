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

<div class="container py-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">📝 Your Task Manager</h2>
            <p class="text-muted">Keep track of your daily goals efficiently</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <form id="taskForm">
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
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">➕ Add Task</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterPriority" class="form-label fw-semibold">Filter by Priority</label>
            <select class="form-select" id="filterPriority">
                <option value="">All</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive shadow-sm">
            <div class="row" id="taskTable">
    <?php foreach ($tasks as $task): ?>
        <div class="col-md-4 mb-4 task-card" data-priority="<?php echo htmlspecialchars($task['priority']); ?>">
            <div class="card shadow border-<?php echo $task['priority'] === 'High' ? 'danger' : ($task['priority'] === 'Medium' ? 'warning' : 'success'); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                    <p class="card-text mb-1"><strong>Deadline:</strong> <?php echo htmlspecialchars($task['deadline']); ?></p>
                    <p class="card-text mb-2">
                        <strong>Priority:</strong> 
                        <span class="badge bg-<?php echo $task['priority'] === 'High' ? 'danger' : ($task['priority'] === 'Medium' ? 'warning' : 'success'); ?>">
                            <?php echo htmlspecialchars($task['priority']); ?>
                        </span>
                    </p>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <button class="btn btn-sm btn-<?php echo $task['status'] === 'completed' ? 'success' : 'outline-secondary'; ?> toggleStatus mb-1" data-id="<?php echo $task['id']; ?>" data-status="<?php echo $task['status']; ?>">
                            <?php echo htmlspecialchars(ucfirst($task['status'])); ?>
                        </button>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-outline-warning me-1 editTask" 
                                data-id="<?php echo $task['id']; ?>" 
                                data-title="<?php echo htmlspecialchars($task['title']); ?>" 
                                data-deadline="<?php echo $task['deadline']; ?>" 
                                data-priority="<?php echo $task['priority']; ?>">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger deleteTask" data-id="<?php echo $task['id']; ?>">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
