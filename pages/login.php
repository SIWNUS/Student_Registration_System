<?php 
session_start();
include("../includes/header.php") 
?>

<?php 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../config/db.php");
      
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = $_POST['pass'];

        if ($email == '') {
            echo "<script>alert('Fill all the fields');</script>";
        } else {
            $sql = "SELECT id, email, password FROM students WHERE email = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row["password"])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['email'] = $row['email'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "<script>alert('Wrong Password');</script>";
                }
            } else {
                echo "<script>alert('No records found');</script>";
            }
        }     
    }
        

?>

    <div>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="col-25">
                <label for="email">E-Mail ID </label>
            </div>
            <div class="col-75">
                <input type="email" id="email" name="email" placeholder="Enter student's mail id here...">
            </div>
            <br><br>
            <div class="col-25">
                <label for="pass">Password </label>
            </div>
            <div class="col-75">
                <input type="password" id="pass" name="pass" placeholder="Set up your password here...">
            </div>
            <br><br>
            <div class="submit-btn">
                <input type="submit" value="submit">
            </div>
        </form>
    </div>
    <br><br>
    <div>
        <p id="redirect">If you are not registered already, then <a href="../pages/register.php">register</a> here. </p>
    </div>

<?php include("../includes/footer.php") ?>