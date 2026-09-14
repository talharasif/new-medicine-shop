<?php include "../control/profileControl.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="navbar">
    <a href="home.php">Home</a>
    <a href="medicines.php">Medicines</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="profileBox">
    <h2>My Profile</h2>

    <?php if (!empty($nameError)): ?>
        <p class="error"><?php echo $nameError; ?></p>
    <?php endif; ?>

    <?php if (!empty($emailError)): ?>
        <p class="error"><?php echo $emailError; ?></p>
    <?php endif; ?>

    <?php if (!empty($addressError)): ?>
        <p class="error"><?php echo $addressError; ?></p>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">

        <h3>Name</h3>
        <input type="text" name="name" value="<?php echo $user['name']; ?>">

        <h3>Email</h3>
        <input type="email" name="email" value="<?php echo $user['email']; ?>">

        <h3>Address</h3>
        <textarea name="address"><?php echo $user['address']; ?></textarea>

        <h3>Role</h3>
        <input type="text" value="<?php echo ucfirst($user['role']); ?>" disabled>

        <input type="submit" name="update" value="Update Profile">

    </form>
</div>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
