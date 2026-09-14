<?php
include "../control/checkout_control.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Customer Checkout</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<h2>Customer Checkout</h2>

<form method="post">

   <h3> Email: </h3>
    <input type="email" name="email" >
    <p> <?php echo $emailError; ?> </p>  <!--error msg dekhanor jnno -->


    <h3> Password:  </h3>
     <input type="password" name="password">
    <p><?php echo $passwordError; ?></p>  <!-- error msg sheta page e dkhacchi -->


    <h3>  Shipping Address:  </h3>
    <textarea name="address" rows="5" cols ="34"></textarea>
    <p><?php echo $addressError; ?></p>


    <h3>Select Medicine</h3>

    <select name="medicine">

        <option value="">--Select Medicine--</option>
        <option value="Paracetamol">Paracetamol</option>
        <option value="Napa">Napa</option>
        <option value="Seclo">Seclo</option>
          <option value="Oradin">Oradin</option>
             <option value="Thyvy">Thyvy</option>

    </select>

    <p><?php echo $medicineError; ?></p>


    <h3>Quantity</h3>

    <input type="number" name="quantity" >

    <p><?php echo $quantityError; ?></p>


    <h3>Payment Method</h3>

    <input type="radio" name="payment" value="CreditCard"> Credit Card
    <br>

    <input type="radio" name="payment" value="bKash"> bKash
    <br>

    <input type="radio" name="payment" value="Nagad"> Nagad
    <br>

    <input type="radio" name="payment" value="CashOnDelivery"> Cash on Delivery

    <p><?php echo $paymentError; ?></p>


    <input type="submit" name="checkout" value="Confirm Purchase">

</form>

</body>

</html>

<!-- http://localhost/admins/view/registration.php -->