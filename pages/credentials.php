<?php
include("../includes/header.php");
?>

<div>
    <h2>Student Registration</h2>
    <form action="" method="post" id="credentialForm">
        <div class="col-25">
            <label for="password">Set Password </label>
        </div>
        <div class="col-75">
            <input type="password" name="password" id="password" placeholder="Enter yoyr password here...">
        </div>
        <br><br>
        <div class="col-25">
            <label for="re_password">Set Password </label>
        </div>
        <div class="col-75">
            <input type="password" name="re_password" id="re_password" placeholder="Enter yoyr password here...">
        </div>
        <br>
        <div class="col-75">
            <span id="message"></span>
        </div>
        <br>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

<script src="../assets/credentialScript.js"></script>
<?php include("../includes/footer.php"); ?>