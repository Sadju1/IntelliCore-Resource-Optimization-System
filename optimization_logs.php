<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$logs = $pdo->query("SELECT ol.*, r.name FROM optimization_logs ol JOIN resources r ON ol.resource_id = r.id ORDER BY ol.created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimization Logs - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Optimization Logs</h1>
        <table>
            <tr>
                <th>Time</th>
                <th>Resource</th>
                <th>Message</th>
                <th>Severity</th>
            </tr>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= date('M j, H:i', strtotime($log['created_at'])) ?></td>
                <td><?= htmlspecialchars($log['name']) ?></td>
                <td><?= htmlspecialchars($log['message']) ?></td>
                <td><span class="severity <?= $log['severity'] ?>"><?= ucfirst($log['severity']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($logs)): ?>
            <tr><td colspan="4">No optimization logs yet.</td></tr>
            <?php endif; ?>
        </table>
        <br><a href="dashboard.php">← Back</a>
    </div>
</body>
</html>