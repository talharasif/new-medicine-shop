<?php

session_start();

if (!isset($_SESSION['id']))
{
    header("Location: ../view/login.php");
    exit();
}

require_once '../model/db.php';

$db = new mydb();

$conn = $db->openConn();

$id = $_SESSION['id'];

$result = $db->getCustomerById(
    $id,
    $conn
);

$user = $result->fetch_assoc();

$nameError = "";
$emailError = "";
$addressError = "";
$message = "";

if (isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (empty($name))
    {
        $nameError = "Name is required";
    }

    if (empty($email))
    {
        $emailError = "Email is required";
    }

    if (empty($address))
    {
        $addressError = "Address is required";
    }

    if (empty($nameError) && empty($emailError) && empty($addressError))
    {
        if (
            $db->updateCustomer(
                $id,
                $name,
                $email,
                $address,
                $conn
            )
        )
        {
            $message = "Profile updated successfully.";

            $result = $db->getCustomerById(
                $id,
                $conn
            );

            $user = $result->fetch_assoc();
        }
        else
        {
            $nameError = "Profile update failed.";
        }
    }
}

?>