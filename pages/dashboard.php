<?php 
include("../includes/header.php");

if (!isset($_SESSION["logged_in"])) {
    echo "<script>alert('You are not logged in! Redirecting to home page!');</script>";
    echo "<script>window.location.assign('../index.php');</script>";
}

include("../config/db.php");
?>

<?php 
    $email = $_SESSION['email'];
    $sql = "SELECT name, email, dob, age, gender, profile_pic FROM students WHERE email = ?;";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $name = $row["name"];
    $email = $row["email"];
    $dob = $row['dob'];
    $gender = $row['gender'];
    $age = $row['age'];
    $profile_pic = $row['profile_pic'];

    $stmt -> close();
?>

<div>
    <h2>Welcome to your dashoboard!</h2>
    <div class="col-25">
        <img src="/api/uploads/<?php echo $profile_pic; ?>" alt="Profile Picture">
        <br>
    </div>
    <div class="col-75">
        <div class="col-25">
            <p>Name</p>
        </div>
        <div class="col-75">
            <p><?php echo $name; ?></p>
        </div>
    </div>
    <div class="col-75">
        <div class="col-25">
            <p>Email: </p>
        </div>
        <div class="col-75">
            <p><?php echo $email; ?></p>
        </div>
    </div>
    <div class="col-75">
    <div class="col-25">
            <p>Date of Birth: </p>
        </div>
        <div class="col-75">
            <p><?php echo $dob; ?></p>
        </div>
    </div>
    <div class="col-75">
    <div class="col-25">
            <p>Age: </p>
        </div>
        <div class="col-75">
            <p><?php echo $age; ?></p>
        </div>
    </div>
    <div class="col-75">
    <div class="col-25">
            <p>Gender: </p>
        </div>
        <div class="col-75">
            <p><?php echo $gender; ?></p>
        </div>
    </div>
</div>

<div>
    <div>
        <a href="../pages/update.php"><button>Update</button></a>
    </div>
</div>


<?php include("../includes/footer.php") ?>