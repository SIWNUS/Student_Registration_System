<?php 
include("../includes/header.php");

if (!isset($_SESSION["logged_in"])) {
    echo "<script>alert('You are not logged in! Redirecting to home page!');</script>";
    echo "<script>window.location.assign('../index.php');</script>";
    exit();
}

include("../config/db.php");

$email = $_SESSION['email'];
$sql = "SELECT name, email, dob, age, gender, profile_pic FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = htmlspecialchars($row["name"]);
$email = htmlspecialchars($row["email"]);
$dob = htmlspecialchars($row["dob"]);
$age = htmlspecialchars($row["age"]);
$gender = htmlspecialchars($row["gender"]);
$profile_pic = htmlspecialchars($row["profile_pic"]);

// Check if profile_pic is not empty and construct the Cloudinary URL
$cloudinary_url = $profile_pic ? "https://res.cloudinary.com/YOUR_CLOUD_NAME/image/upload/$profile_pic" : "/assets/default_profile.png"; // default fallback image

$stmt->close();
?>

<div class="dashboard-container">
    <h2>Welcome to your Dashboard!</h2>

    <div class="profile-section">
        <img src="<?php echo $cloudinary_url; ?>" alt="Profile Picture" width="150" height="150" style="border-radius: 50%; object-fit: cover;">
    </div>

    <div class="info-section">
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Age:</strong> <?php echo $age; ?></p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
    </div>

    <div class="update-btn">
        <a href="../pages/update.php">
            <button type="button">Update</button>
        </a>
    </div>
</div>

<?php include("../includes/footer.php") ?>