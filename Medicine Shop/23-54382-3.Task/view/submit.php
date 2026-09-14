<?php

session_start();
//checkout_control.php theke session e rakha data access korar jonno session start korechi

include "../model/db.php";
//cart table theke data anar jonno db.php include korechi

?>
<!DOCTYPE html>
<html>
<head>
<title>Order Confirmation</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body>
<h2>Order Confirmation</h2>
<p>
Your order has been placed successfully.
</p>
<h3>Order Information</h3>
<p>

Order ID:

<?php
//session e order id ache kina check korchi
if(isset($_SESSION['order_id'])){

    echo $_SESSION['order_id'];
}
else{
   echo "Order ID not found";

}

?>

</p>
<h3>Customer Information</h3>
<p>
<!--customer email show kore-->
Email:
<?php echo $_SESSION['email']; ?>
</p>


<p>
Address:

<?php echo $_SESSION['address']; ?>

</p>


<h3>Invoice</h3>

<table border="1">

<tr>

<th>Medicine Name</th>

<th>Quantity</th>

</tr>


<tr>

<td>

<?php echo $_SESSION['invoice_medicine']; ?>
<!--order id theke medi. name dekhai-->
</td>


<td>

<?php echo $_SESSION['invoice_quantity']; ?>
<!--order id theke quan. name dekhai-->
</td>
</tr>

</table>


<h3>Cart Management</h3>

<table border="1">

<tr>

<th>Medicine Name</th>

<th>Quantity</th>

<th>Action</th>

</tr>


<?php

//database connection create korchi cart data anar jonno
$db=new mydb();

$conn=$db->openConn();

//cart table theke medicine and quantity data fetch korchi

$cartResult=$db->getCartData($conn);

while($cartRow=$cartResult->fetch_assoc()){
//database theke shb cart item ek ek kore ber kori
?>

<tr>

<td>
<?php echo $cartRow['medicine_name']; ?>
</td>


<td>
<?php echo $cartRow['quantity']; ?>
</td>


<td>
<!--ajax button,btn chple js func call hoi-->
<button onclick="increaseCart(<?php echo $cartRow['id']; ?>)">
+
</button>

<button onclick="decreaseCart(<?php echo $cartRow['id']; ?>)">
-
</button>

<button onclick="removeCart(<?php echo $cartRow['id']; ?>)">
Remove
</button>

</td>

</tr>



<?php

}

?>


</table>




<h3>Payment Information</h3>


<p>

Payment Method:

<?php echo $_SESSION['payment_method']; ?>

</p>




<h3>Order Status</h3>


<p>

<?php echo $_SESSION['status']; ?>

</p>



<script src="../js/myjs.js?v=1"></script>
<!--js file load krchi krn ei file ei increa.decrea,remv () ache -->

</body>

</html>