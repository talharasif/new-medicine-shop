<?php 
include "../control/login_control.php"; 
?>

<!DOCTYPE html>
<html>

<head>

<title>Medicine Shop Login</title>

<link rel="stylesheet" href="../css/mycss.css">

</head>


<body class="login-body">


<div class="login-box">


    <div class="login-header">

        <h2>💊 Medicine Shop</h2>

        <p>Customer Login</p>

    </div>



    <form method="post" action="">


        <label>Email</label>

        <input 
        type="email" 
        name="email" 
        placeholder="Enter your email"
        required>


        <label>Password</label>

        <input 
        type="password" 
        name="password"
        placeholder="Enter your password"
        required>


        <input 
        type="submit" 
        name="login" 
        value="Login"
        class="login-btn">


    </form>


    <p class="footer-text">

        Online Medicine Shop

    </p>


</div>


</body>

</html>