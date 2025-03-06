<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register System</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <header>
        <nav>
            <?php session_start(); ?>
            <a href="../index.php" id="home">Home</a>
            <?php if (isset($_SESSION['logged_in'])): ?>
                <a href="../logout.php" id="func">Logout</a>
                <?php if (isset($_SESSION['email']) && $_SESSION['email'] === 'suswinpalaniswamy@gmail.com'): ?>
                    <a href="../pages/students.php" id="func">Students List</a>
                <?php endif; ?>
                <a href="../pages/dashboard.php" id="func">Dashboard</a>
            <?php else: ?>
                <a href="../pages/register.php" id="func">Register</a>
                <a href="../pages/login.php" id="func">Log In</a>
            <?php endif; ?>

            
        </nav>
    </header>
    <!-- main content goes here -->
    <main>