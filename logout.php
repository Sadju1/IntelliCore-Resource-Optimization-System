<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION['user_id'], "User logged out"]);
}

session_destroy();
header("Location: login.php");
exit();