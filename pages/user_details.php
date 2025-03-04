<?php
session_start();
include("../includes/header.php");
?>

<div>
    <h2>Student Registration</h2>
    <form action="" method="post" id="detailsForm">
        <div class="col-25">
            <label for="name">Student Name</label>
        </div>
        <div class="col-75">
            <input type="text" name="name" id="name" placeholder="Enter your name here...">
        </div>
        <br><br>
        <div class="col-25">
            <label for="dob">Date of Birth</label>
        </div>
        <div class="col-75">
            <input type="date" name="dob" id="dob">
        </div>
        <br><br>
        <div class="col-25">
            <label for="gender">Gender</label>
        </div>
        <div class="col-75">
            <select name="gender" id="gender">
                <option value="">--Select--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
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
        <div>
            <input type="submit" value="Register">
        </div>
    </form>
</div>

<?php include("../includes/footer.php"); ?>