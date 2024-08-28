<?php
include 'config/db.php';
include 'templates/header.php';
?>

<div class="container mt-4">
    <h1>Welcome to LMS</h1>
    <p class="lead">A minimal Learning Management System</p>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="public/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    <?php else: ?>
        <a href="public/register.php" class="btn btn-primary">Register</a>
        <a href="public/login.php" class="btn btn-secondary">Login</a>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>