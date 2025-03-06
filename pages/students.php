<?php
include("../includes/header.php");

if (!isset($_SESSION['logged_in']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("../config/db.php");

?>

<?php 
    $sql = "SELECT name, email, dob, age, gender, profile_pic FROM students WHERE email <> 'suswinpalaniswamy@gmail.com';";
    $result = $conn->query($sql);
?>

<h2 style="font-weight: lighter; text-decoration: underline;">Below is a list of all Students</h2>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Gender</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><img src="../uploads/<?php echo htmlspecialchars($row['profile_pic']); ?>" class="profile-pic" alt="Profile"></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td id="mail_delete"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['dob']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><button class="delete" data-email="<?php echo htmlspecialchars($row['email']); ?>">Delete</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>