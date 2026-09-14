<?php include "../control/loginControl.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <form method="post">

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

        <input type="submit" name="login" value="Login">

    </form>

    <br>

    <a href="register.php">Create Account</a>
</div>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
