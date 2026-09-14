<?php

class mydb{

    function openConn(){

 // database er sathe connection create korchi
  //localhost, username, password and database name diye MySQL connect korchi

        return new mysqli("localhost","root","","OnlineMedicineShop");

    }

    function insertCustomer($email,$password,$address,$conn){

        //customer table e customer information save korchi
        // email,pass,adrsss column e email,... jabe
      

        $sql="INSERT INTO customer(email,password,address)
        VALUES('$email','$password','$address')";

        return $conn->query($sql);

    }


    function insertCart($medicine,$quantity,$conn){

 //ncart table e medicine and quantity save korchi
//medicine_name column e selected medicine jabe,qyatity jbe quatity er jnno
       
        $sql="INSERT INTO cart(medicine_name,quantity)
        VALUES('$medicine','$quantity')";

        return $conn->query($sql);

    }


    function insertOrder($address,$payment,$conn){

        //orders table e checkout information save korchi
        //address column e customer shipping address jabe,payment_method column e selected payment method jabe,status column e pending admin approval save hbe

        $sql="INSERT INTO orders(address,payment_method,status)
        VALUES('$address','$payment','pending admin approval')";

        return $conn->query($sql);

    }


    function insertOrderItem($medicine,$quantity,$conn){

//order_items table e medicine details save korchi
//medicine_name column e selected medicine jabe
//quantity column e selected quantity jabe

        $sql="INSERT INTO order_items(medicine_name,quantity)
        VALUES('$medicine','$quantity')";

        return $conn->query($sql);

    }


    function insertPayment($payment,$conn){

//payments table e payment information save korchi
//payment_method column e selected payment method jabe

        $sql="INSERT INTO payments(payment_method)
        VALUES('$payment')";

        return $conn->query($sql);

    }

    function getCustomerData($conn){

 //customer table theke last inserted customer data nicchi
//submit.php te show korar jonno data return korchi

        $sql="SELECT * FROM customer ORDER BY id DESC LIMIT 1";

        return $conn->query($sql);

    }

    function getCartData($conn){
//cart table theke medicine and quantity data fetch korchi
//cart data show korar jonno return korchi

        $sql="SELECT * FROM cart";

        return $conn->query($sql);}


    function getOrderData($conn){

//orders table theke latest order data fetch korchi
//submit.php te address, payment and status show korar jonno

        $sql="SELECT * FROM orders ORDER BY id DESC LIMIT 1";

        return $conn->query($sql);
    }


    function getOrderItemData($conn){
//order_items table theke medicine and quantity data fetch korchi
//invoice e medicine details show korar jonno

        $sql="SELECT * FROM order_items ORDER BY id DESC LIMIT 1";

        return $conn->query($sql);
}

    function updateCartQuantity($id,$quantity,$conn){
//cart table er specific item er quantity update korchi
//increase and decrease button er jonno use hobe

        $sql="UPDATE cart SET quantity='$quantity' WHERE id='$id'";

        return $conn->query($sql);
 }


    function removeCartItem($id,$conn){
//cart table theke selected item delete korchi
// remove button er jonno use hobe

        $sql="DELETE FROM cart WHERE id='$id'";

        return $conn->query($sql);
 }


    function clearCart($conn){
//order complete howar por cart table er shob item delete korchi
//payment and order save howar por cart empty korar jonno use korchi

        $sql="DELETE FROM cart";

        return $conn->query($sql);
    }

}

?>