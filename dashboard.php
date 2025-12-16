<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>!</h1>
            <p class="subtitle">IntelliCore Resource Optimization System</p>
        </header>

        <nav class="dashboard-menu">
            <a href="add_resource.php">Add New Resource</a>
            <a href="manage_resources.php">Manage Resources</a>
            <a href="use_resource.php">Use a Resource</a>
            <a href="optimization_logs.php">View Optimization Logs</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>

        <div class="stats">
            <?php
            $total = $pdo->query("SELECT COUNT(*) FROM resources")->fetchColumn();
            $in_use = $pdo->query("SELECT COUNT(*) FROM resources WHERE status = 'in_use'")->fetchColumn();
            $available = $pdo->query("SELECT COUNT(*) FROM resources WHERE status = 'available'")->fetchColumn();
            ?>
            <div class="stat-card">
                <h3>Total Resources</h3>
                <span><?= $total ?></span>
            </div>
            <div class="stat-card green">
                <h3>Available</h3>
                <span><?= $available ?></span>
            </div>
            <div class="stat-card red">
                <h3>In Use</h3>
                <span><?= $in_use ?></span>
            </div>
        </div>
    </div>
</body>
</html>