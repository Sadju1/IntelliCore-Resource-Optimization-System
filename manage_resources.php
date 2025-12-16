<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM resources WHERE id = ?")->execute([$id]);
    $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION['user_id'], "Deleted resource ID: $id"]);
    header("Location: manage_resources.php");
    exit();
}

$resources = $pdo->query("SELECT * FROM resources ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Resources</h1>
        <a href="add_resource.php" class="btn-add">+ Add New Resource</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resources as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['category']) ?></td>
                    <td><?= htmlspecialchars($r['location'] ?? '—') ?></td>
                    <td><span class="status <?= $r['status'] ?>"><?= ucfirst(str_replace('_', ' ', $r['status'])) ?></span></td>
                    <td>
                        <a href="use_resource.php?start=<?= $r['id'] ?>" class="btn-small">Use</a>
                        <a href="manage_resources.php?delete=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('Delete this resource?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($resources)): ?>
                <tr><td colspan="6" style="text-align:center;">No resources yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br><a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>