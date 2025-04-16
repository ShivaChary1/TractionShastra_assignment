<?php
require_once 'includes/header.php';
require_once 'includes/tasks.php';
if (!isAdmin()) {
    header('Location: dashboard.php');
    exit;
}
$tasks = getAllTasks();
?>
<h2>Admin Panel - All Tasks</h2>
<table id="taskTable" class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Title</th>
            <th>Deadline</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['name']); ?></td>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['deadline']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td>
                    <button class="btn btn-sm btn-<?php echo $task['status'] === 'completed' ? 'success' : 'secondary'; ?> toggleStatus" data-id="<?php echo $task['id']; ?>" data-status="<?php echo $task['status']; ?>">
                        <?php echo htmlspecialchars($task['status']); ?>
                    </button>
                </td>
                <td>
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