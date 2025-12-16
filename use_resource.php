<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Start usage
if (isset($_GET['start'])) {
    $resource_id = (int)$_GET['start'];
    $pdo->prepare("INSERT INTO resource_usage (resource_id, user_id, start_time) VALUES (?, ?, NOW())")->execute([$resource_id, $_SESSION['user_id']]);
    $pdo->prepare("UPDATE resources SET status = 'in_use' WHERE id = ?")->execute([$resource_id]);
    $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION['user_id'], "Started using resource ID: $resource_id"]);
    header("Location: use_resource.php");
    exit();
}

// Stop usage
if (isset($_POST['stop'])) {
    $usage_id = (int)$_POST['usage_id'];
    $stmt = $pdo->prepare("SELECT resource_id, start_time FROM resource_usage WHERE id = ? AND user_id = ? AND end_time IS NULL");
    $stmt->execute([$usage_id, $_SESSION['user_id']]);
    $usage = $stmt->fetch();

    if ($usage) {
        $seconds = strtotime("now") - strtotime($usage['start_time']);
        $pdo->prepare("UPDATE resource_usage SET end_time = NOW(), duration_seconds = ? WHERE id = ?")->execute([$seconds, $usage_id]);
        $pdo->prepare("UPDATE resources SET status = 'available' WHERE id = ?")->execute([$usage['resource_id']]);

        // Optimization suggestion
        $message = $seconds > 3600 ? "High usage detected ($seconds seconds). Consider scheduling." : "Normal usage.";
        $severity = $seconds > 7200 ? 'high' : ($seconds > 3600 ? 'medium' : 'low');
        $pdo->prepare("INSERT INTO optimization_logs (resource_id, message, severity) VALUES (?, ?, ?)")->execute([$usage['resource_id'], $message, $severity]);

        $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION['user_id'], "Stopped using resource ID: " . $usage['resource_id']]);
    }
    header("Location: use_resource.php");
    exit();
}

// Get available & in-use
$available = $pdo->query("SELECT id, name FROM resources WHERE status = 'available'")->fetchAll();
$my_usage = $pdo->prepare("SELECT ru.id, r.name, ru.start_time FROM resource_usage ru JOIN resources r ON ru.resource_id = r.id WHERE ru.user_id = ? AND ru.end_time IS NULL");
$my_usage->execute([$_SESSION['user_id']]);
$ongoing = $my_usage->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Use Resource - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Use a Resource</h1>

        <h2>Available Resources</h2>
        <?php if ($available): ?>
            <div class="grid">
                <?php foreach ($available as $r): ?>
                    <div class="card">
                        <strong><?= htmlspecialchars($r['name']) ?></strong>
                        <a href="use_resource.php?start=<?= $r['id'] ?>" class="btn">Start Using</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No resources available right now.</p>
        <?php endif; ?>

        <h2>My Active Usage</h2>
        <?php if ($ongoing): ?>
            <table>
                <tr><th>Resource</th><th>Started</th><th>Action</th></tr>
                <?php foreach ($ongoing as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= date('M j, H:i', strtotime($u['start_time'])) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="usage_id" value="<?= $u['id'] ?>">
                            <button type="submit" name="stop" class="btn-stop">Stop</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>You are not using any resource.</p>
        <?php endif; ?>

        <br><a href="dashboard.php">← Back</a>
    </div>
</body>
</html>