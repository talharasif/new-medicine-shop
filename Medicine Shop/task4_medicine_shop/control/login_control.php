<?php

session_start();

include "../model/db.php";


if(isset($_POST['login']))
{

    $email=$_POST['email'];
    $password=$_POST['password'];


    $db=new mydb();

    $conn=$db->openConn();


    $sql="SELECT * FROM users WHERE email='$email'";

    $result=$conn->query($sql);



    if($result->num_rows>0)
    {

        $user=$result->fetch_assoc();


        if(password_verify($password,$user['password_hash']))
        {

            $_SESSION['user_id']=$user['id'];
            $_SESSION['name']=$user['name'];
            $_SESSION['role']=$user['role'];


           header("location:../view/order_history.php");
            exit();

        }
        else
        {
            echo "Wrong Password";
        }


    }
    else
    {
        echo "User not found";
    }


}

?>