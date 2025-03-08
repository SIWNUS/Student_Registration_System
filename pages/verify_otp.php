<?php
include("../includes/header.php");
?>

<div>
    <h2>Student Registration</h2>
    <form action="" method="post" id="validateOtp">
        <div class="col-25">
            <label for="otp">Enter OTP </label>
        </div>
        <div class="col-75">
            <input type="text" name="otp" id="otp" placeholder="Enter your 6-digit OTP here...">
        </div>
        <br><br>
        <div class="col-75">
            <span id="message"></span>
        </div>
        <br>
        <div>
            <button type="submit">Validate</button>
        </div>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
