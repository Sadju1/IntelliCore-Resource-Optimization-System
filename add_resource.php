<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO resources (name, category, location, purchase_date, cost, estimated_lifetime_months, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['category'],
        $_POST['location'],
        $_POST['purchase_date'] ?: null,
        $_POST['cost'] ?: 0,
        $_POST['lifetime'] ?: 60,
        $_POST['notes']
    ]);

    $log = $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)");
    $log->execute([$_SESSION['user_id'], "Added resource: " . $_POST['name']]);

    header("Location: manage_resources.php?added=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resource - IntelliCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Resource</h1>
        <form method="POST">
            <label>Name <span class="req">*</span></label>
            <input type="text" name="name" required>

            <label>Category <span class="req">*</span></label>
            <input type="text" name="category" required placeholder="e.g., Laptop, Projector, Lab Equipment">

            <label>Location</label>
            <input type="text" name="location" placeholder="e.g., Room 301">

            <label>Purchase Date</label>
            <input type="date" name="purchase_date">

            <label>Cost (USD)</label>
            <input type="number" step="0.01" name="cost" placeholder="0.00">

            <label>Estimated Lifetime (months)</label>
            <input type="number" name="lifetime" value="60">

            <label>Notes</label>
            <textarea name="notes" rows="3"></textarea>

            <div class="form-actions">
                <button type="submit">Add Resource</button>
                <a href="dashboard.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>