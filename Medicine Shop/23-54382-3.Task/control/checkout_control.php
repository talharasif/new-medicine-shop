<?php

session_start();
//session start korechi jate database theke ana data submit.php te pathate pari

include "../model/db.php"; 
//model folder theke db.php file include korechi, karon database function use korbo

$emailError="";
$passwordError="";
$addressError="";
$medicineError="";
$quantityError="";
$paymentError="";


$email="";
$address="";
$medicine="";
$quantity="";
$payment="";


if(isset($_POST['checkout'])){  
//varisble ba valur ache kina check korchi


    $email=$_POST['email'];   
    //form theke submitted data nicchi

    $password=$_POST['password'];
    $address=$_POST['address'];
    $medicine=$_POST['medicine'];
    $quantity=$_POST['quantity'];



    if(isset($_POST['payment'])){

        $payment=$_POST['payment'];

    }



    //email validation
    if(empty($email)){

        $emailError="Email is required";

    }



    //password validation
    if(empty($password)){

        $passwordError="Password is required";

    }
    elseif(strlen($password)<8){

        $passwordError="Password must be minimum 8 characters";

    }



    //address validation
    if(empty($address)){

        $addressError="Shipping address is required";

    }



    //medicine validation
    if(empty($medicine)){

        $medicineError="Please select medicine";

    }



    //quantity validation
    if(empty($quantity)){

        $quantityError="Quantity is required";

    }
    elseif($quantity<=0){

        $quantityError="Quantity must be greater than 0";

    }



    //payment validation
    if(empty($payment)){

        $paymentError="Select payment method";

    }




    //if there is no error

    if(
        empty($emailError) &&
        empty($passwordError) &&
        empty($addressError) &&
        empty($medicineError) &&
        empty($quantityError) &&
        empty($paymentError)
    ){

        $db=new mydb(); 
     //db.php er mydb class er object create korechi, jate database function access korte pari


        $conn=$db->openConn(); 
  // openConn() call kore database er sathe connection create korechi

        $db->insertCustomer(
            $email,
            $password,
            $address,
            $conn
        );

 //customer table e email, password and address save korchi

        $db->insertCart(
            $medicine,
            $quantity,
            $conn
        );

 //cart table e medicine and quantity save korchi

        $db->insertOrder(
            $address,
            $payment,
            $conn
        );

 //orders table e address, payment and status save korchi

        $db->insertOrderItem(
            $medicine,
            $quantity,
            $conn
        );

 //order_items table e medicine and quantity save korchi

        $db->insertPayment(
            $payment,
            $conn
        );

//payments table e payment method save korchi

       /// $db->clearCart($conn);

     // order and payment save howar por cart table clear korchi
     //old cart item remove kore new order er jonno cart empty korchi

//customer table theke latest customer data fetch korchi

        $result=$db->getCustomerData($conn);

        $row=$result->fetch_assoc();

        $_SESSION['email']=$row['email'];

        $_SESSION['address']=$row['address'];

 //orders table theke latest order data fetch korchi
 //submit.php te address, payment and status show korar jonno

        $orderResult=$db->getOrderData($conn);

        $orderRow=$orderResult->fetch_assoc();

        $_SESSION['order_address']=$orderRow['address'];

        $_SESSION['payment_method']=$orderRow['payment_method'];

        $_SESSION['status']=$orderRow['status'];

 //orders table theke order id session e store korchi
 //submit.php te order id show korar jonno


        $_SESSION['order_id']=$orderRow['id'];

 //order_items table theke medicine and quantity fetch korchi
 //invoice e medicine details show korar jonno

        $itemResult=$db->getOrderItemData($conn);

        $itemRow=$itemResult->fetch_assoc();

        $_SESSION['invoice_medicine']=$itemRow['medicine_name'];

        $_SESSION['invoice_quantity']=$itemRow['quantity'];

//form theke paoa medicine, quantity and payment session e store korchi
 //submit.php te show korar jonno

        $_SESSION['medicine']=$medicine;

        $_SESSION['quantity']=$quantity;

        $_SESSION['payment']=$payment;



        header("Location: ../view/submit.php");
//session e data store howar por submit.php te redirect korchi

exit();

 }

}


?>