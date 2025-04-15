CREATE DATABASE task_app;
USE task_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    deadline DATE NOT NULL,
    priority ENUM('High', 'Medium', 'Low') NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample data
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@example.com', '$2y$10$3Xz6Z9X7Y7Z6Y9X7Z6Y7Zu3Xz6Z9X7Y7Z6Y9X7Z6Y7Z', 'admin'),
('John Doe', 'john@example.com', '$2y$10$3Xz6Z9X7Y7Z6Y9X7Z6Y7Zu3Xz6Z9X7Y7Z6Y9X7Z6Y7Z', 'user');

INSERT INTO tasks (user_id, title, deadline, priority, status) VALUES
(2, 'Complete project', '2025-04-20', 'High', 'pending'),
(2, 'Write report', '2025-04-18', 'Medium', 'pending');
