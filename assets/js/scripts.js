document.addEventListener('DOMContentLoaded', () => {
    const taskForm = document.getElementById('taskForm');
    const taskTable = document.getElementById('taskTable');
    const filterPriority = document.getElementById('filterPriority');

    // Form validation
    taskForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!taskForm.checkValidity()) {
            e.stopPropagation();
            taskForm.classList.add('was-validated');
            return;
        }

        const formData = new FormData(taskForm);
        try {
            const response = await fetch('dashboard.php', {
                method: 'POST',
                body: formData
            });
            if (response.ok) {
                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Edit task
    taskTable?.addEventListener('click', (e) => {
        if (e.target.classList.contains('editTask')) {
            const id = e.target.dataset.id;
            const title = e.target.dataset.title;
            const deadline = e.target.dataset.deadline;
            const priority = e.target.dataset.priority;

            document.getElementById('taskId').value = id;
            document.getElementById('title').value = title;
            document.getElementById('deadline').value = deadline;
            document.getElementById('priority').value = priority;
            document.getElementById('action').value = 'update';
            document.getElementById('submitBtn').textContent = 'Update Task';
        }

        // Delete task
        if (e.target.classList.contains('deleteTask')) {
            if (confirm('Are you sure you want to delete this task?')) {
                const id = e.target.dataset.id;
                fetch('delete_task.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `task_id=${id}`
                }).then(() => location.reload());
            }
        }
    });

    // Filter tasks by priority
    filterPriority?.addEventListener('change', (e) => {
        const priority = e.target.value;
        const rows = taskTable.querySelectorAll('tr');
        rows.forEach(row => {
            if (!priority || row.dataset.priority === priority) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
