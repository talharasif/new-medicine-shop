<?php

require_once '../model/db.php';

$nameError = "";
$emailError = "";
$passwordError = "";
$addressError = "";

$name = "";
$email = "";
$address = "";

if (isset($_POST['register']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    if (empty($name))
    {
        $nameError = "Name is required";
    }

    if (empty($email))
    {
        $emailError = "Email is required";
    }

    if (empty($password))
    {
        $passwordError = "Password is required";
    }
    elseif (strlen($password) < 8)
    {
        $passwordError = "Password must be minimum 8 characters";
    }

    if (empty($address))
    {
        $addressError = "Address is required";
    }

    if (
        empty($nameError) &&
        empty($emailError) &&
        empty($passwordError) &&
        empty($addressError)
    )
    {
        $db = new mydb();

        $conn = $db->openConn();

        $role = "customer";

        if (
            $db->insertCustomer(
                $name,
                $email,
                $password,
                $address,
                $role,
                $conn
            )
        )
        {
            header("Location: login.php");
            exit();
        }
        else
        {
            $emailError = "Registration failed. Email may already exist.";
        }
    }
}

?>