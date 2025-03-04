<?php 
session_start();
include("includes/header.php") ?>
        <h2>Welcome to the Student Register System</h2>
        <p>This system allows the students to register, log-in and manage their data accordingly.</p>
        <?php if ($_SESSION['user_id']): ?>
        <p>You can view your data ias your <a href="pages/dashboard.php">dashboard</a>. </p>
        <?php else: ?>
        <p>To get started, please <a href="pages/register.php">register</a> or <a href="pages/login.php">login</a>.</p>
        <?php endif ?>
<?php include("includes/footer.php") ?>