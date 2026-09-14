<?php
$name = "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="navbar">
    <a href="adminhome.php">Home</a>
    <a href="medicines.php">Medicines</a>
    <a href="customers.php">Customers</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="homeBox">
    <h2>Welcome Admin, <?php echo $name; ?>!</h2>
    <a href="medicines.php" class="btn-link">View Medicines</a>
    <br><br>
    <a href="customers.php" class="btn-link">Manage Customers</a>
    <br><br>
    <a href="profile.php" class="btn-link">My Profile</a>
</div>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
