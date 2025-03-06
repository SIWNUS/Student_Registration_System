<?php
session_start();
include("../includes/header.php");
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
    <h2>Student Details Update Form</h2>
    <form action="" method="post" id="updateForm">
        <div class="col-25">
            <label for="name">Student Name</label>
        </div>
        <div class="col-75">
            <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        </div>
        <br><br>
        <div class="col-25">
            <label for="email">Enter your E-Mail </label>
        </div>
        <div class="col-75">
            <input type="email" name="email" id="email" value="<?php echo $email; ?>">
        </div>
        <br><br>
        <div class="col-25">
            <label for="dob">Date of Birth</label>
        </div>
        <div class="col-75">
            <input type="date" name="dob" id="dob" value="<?php echo $dob; ?>">
        </div>
        <br><br>
        <div class="col-25">
            <label for="gender">Gender</label>
        </div>
        <div class="col-75">
            <select name="gender" id="gender" required>
                <option value="Male" <?php if($gender === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($gender === 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($gender === 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <br><br>
        <div class="col-25">
            <label for="myfile">Profile Pic</label>
        </div>
        <div class="col-75">
            <input type="file" name="myfile" id="myfile">
            <span>(only 'jpg', 'jpeg', 'png' formats are accepted. max filesize = 5mb)</span>
        </div>
        <br><br>
        <div class="col-75">
            <span id="message"></span>
        </div>
        <br>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
</div>

<?php include("../includes/footer.php"); ?>