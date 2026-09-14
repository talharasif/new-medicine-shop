<?php include "../control/registrationControl.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="container">
    <h2>Registration</h2>

    <form method="post">

        <h3>Name</h3>
        <input type="text" name="name" value="<?php echo $name; ?>">
        <?php if (!empty($nameError)): ?>
            <p class="error"><?php echo $nameError; ?></p>
        <?php endif; ?>

        <h3>Email</h3>
        <input type="email" name="email" value="<?php echo $email; ?>">
        <?php if (!empty($emailError)): ?>
            <p class="error"><?php echo $emailError; ?></p>
        <?php endif; ?>

        <h3>Password</h3>
        <input type="password" name="password">
        <?php if (!empty($passwordError)): ?>
            <p class="error"><?php echo $passwordError; ?></p>
        <?php endif; ?>

        <h3>Address</h3>
        <textarea name="address"><?php echo $address; ?></textarea>
        <?php if (!empty($addressError)): ?>
            <p class="error"><?php echo $addressError; ?></p>
        <?php endif; ?>

        <input type="submit" name="register" value="Register">

    </form>

    <br>

    <a href="login.php">Already have an account? Login</a>
</div>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
