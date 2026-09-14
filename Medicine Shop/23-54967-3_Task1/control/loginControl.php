<?php

session_start();
require_once '../model/db.php';

$emailError = "";
$passwordError = "";

$email = "";

if (isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email))
    {
        $emailError = "Email is required";
    }

    if (empty($password))
    {
        $passwordError = "Password is required";
    }

    if (empty($emailError) && empty($passwordError))
    {
        $db = new mydb();

        $conn = $db->openConn();

        $result = $db->checkLogin(
            $email,
            $password,
            $conn
        );

        if ($result && $result->num_rows > 0)
        {
            $user = $result->fetch_assoc();
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] == "admin")
            {
                header("Location: adminhome.php");
            }
            else
            {
                header("Location: home.php");
            }

            exit();
        }
        else
        {
            $passwordError = "Invalid email or password.";
        }
    }
}

?>