<?php 
session_start();
include("../includes/header.php");
?>

<div>
    <h2>Student Registration</h2>
    <form action="" method="post" id="getOtp">
        <div class="col-25">
            <label for="email">Enter your E-Mail </label>
        </div>
        <div col-75>
            <input type="email" name="email" id="email" placeholder="something@domain.com">
        </div>
        <br>
        <div>
            <button type="submit">Get OTP</button>
        </div>
    </form>
</div>

<?php include("../includes/footer.php");