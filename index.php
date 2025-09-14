<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task App Registration</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h2>Task App Registration</h2>
        <form id="registrationForm" method="POST" action="mail.php">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn">Register & Send Welcome Email</button>
        </form>
        <div id="message" class="message"></div>
        <div class="users-list">
            <h3>Registered Users</h3>
            <?php
            require_once 'db.php';
            try {
                $pdo = getDBConnection();
                $stmt = $pdo->query("SELECT name, email, created_at FROM users ORDER BY created_at ASC");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($users) > 0) {
                    echo "<ol>";
                    foreach ($users as $user) {
                        echo "<li>";
                        echo "<strong>" . htmlspecialchars($user['name']) . "</strong><br>";
                        echo "Email: " . htmlspecialchars($user['email']) . "<br>";
                        echo "Registered: " . date('M d, Y H:i', strtotime($user['created_at']));
                        echo "</li>";
                    }
                    echo "</ol>";
                } else {
                    echo "<p>No users registered yet.</p>";
                }
            } catch(PDOException $e) {
                echo "<p>Error loading users: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const messageDiv = document.getElementById('message');
            
            fetch('mail.php', { method: 'POST', body: formData })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                messageDiv.style.display = 'block';
                messageDiv.textContent = data.message;
                if (data.success) {
                    messageDiv.className = 'message success';
                    this.reset();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    messageDiv.className = 'message error';
                }
            })
            .catch(error => {
                messageDiv.style.display = 'block';
                messageDiv.className = 'message error';
                messageDiv.textContent = 'Fetch Error: ' + error.message;
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
