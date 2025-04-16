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

    // Handle task table interactions
    taskTable?.addEventListener('click', async (e) => {
        // Edit task
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
                try {
                    const response = await fetch('delete_task.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `task_id=${id}`
                    });
                    const result = await response.json();
                    if (result.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete task');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error deleting task');
                }
            }
        }

        
        // Toggle task status
        if (e.target.classList.contains('toggleStatus')) {
            const id = e.target.dataset.id;
            const currentStatus = e.target.dataset.status;
            const newStatus = currentStatus === 'completed' ? 'pending' : 'completed';

            try {
                const response = await fetch('update_task_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `task_id=${id}&status=${newStatus}`
                });
                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Failed to update task status');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error updating task status');
            }
        }
    });

        // Filter tasks by priority
    filterPriority?.addEventListener('change', (e) => {
        const priority = e.target.value;
        const cards = taskTable.querySelectorAll('.task-card');
        cards.forEach(card => {
            if (!priority || card.dataset.priority === priority) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

});