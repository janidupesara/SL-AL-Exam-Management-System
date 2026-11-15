<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = $pageTitle ?? 'SL A/L Study Tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php if (!empty($_SESSION['user_id'])): ?>
<header class="topbar">
  <a class="brand" href="index.php?url=dashboard/index"><span class="brand-mark">A</span> SL A/L <span class="muted-brand">STUDY TRACKER</span></a>
  <nav><a href="index.php?url=dashboard/index">Dashboard</a><a href="index.php?url=study/mark">Mark Time</a><a href="index.php?url=archive/index">Previous Charts</a><a href="index.php?url=profile/index">Profile</a><a class="logout" href="index.php?url=auth/logout">Log out</a></nav>
</header>
<?php endif; ?>
<main class="<?= empty($_SESSION['user_id']) ? 'auth-main' : 'main-container' ?>">
