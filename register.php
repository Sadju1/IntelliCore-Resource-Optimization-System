<?php
session_start();
require 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];

    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        try {
            // Check if username or email already exists
            $check = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $check->execute([$username, $email]);
            if ($check->fetch()) {
                $error = "Username or email already exists.";
            } else {
                // AUTO-FIX: Ensure role_id 2 exists, create if missing
                $role_check = $pdo->query("SELECT id FROM roles WHERE id = 2")->fetch();
                if (!$role_check) {
                    $pdo->exec("INSERT INTO roles (id, name) VALUES (2, 'User') ON DUPLICATE KEY UPDATE name = 'User'");
                }

                // Now safe to insert
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password_hash, role_id) VALUES (?, ?, ?, ?, 2)");
                $stmt->execute([$full_name, $username, $email, $hash]);

                $user_id = $pdo->lastInsertId();

                // Log activity
                $log = $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)");
                $log->execute([$user_id, "New user registered"]);

                $success = "Registration successful! <a href='login.php'>Click here to login</a>";
            }
        } catch (PDOException $e) {
            // Show helpful message only in development
            $error = "Registration failed: " . $e->getMessage();
            // For production, use: $error = "An error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Create Account</h1>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">

            <label>Username</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

            <label>Email</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label>Password (min 6 characters)</label>
            <input type="password" name="password" required minlength="6">

            <button type="submit">Register</button>
        </form>

        <p><a href="login.php">Already have an account? Login here</a></p>
    </div>
</body>
</html>