<?php

include "../control/order_control.php";

?>


<html>

<head>

<title>Invoice</title>

</head>


<body>


<h2>Online Medicine Shop</h2>

<hr>


<?php

$order=$invoiceOrder->fetch_assoc();

?>


<h3>Customer Information</h3>


<p>
Name:
<?php echo $order['name']; ?>
</p>


<p>
Email:
<?php echo $order['email']; ?>
</p>


<p>
Address:
<?php echo $order['shipping_address']; ?>
</p>



<h3>Order Information</h3>


<p>
Order ID:
<?php echo $order['id']; ?>
</p>


<p>
Date:
<?php echo $order['order_date']; ?>
</p>


<p>
Status:
<?php echo $order['status']; ?>
</p>



<h3>Medicine List</h3>


<table border="1">

<tr>

<th>Medicine</th>
<th>Vendor</th>
<th>Quantity</th>
<th>Price</th>

</tr>



<?php

$total=0;


while($item=$invoiceItems->fetch_assoc())

{

$subtotal=$item['quantity']*$item['unit_price'];

$total += $subtotal;

?>


<tr>

<td>
<?php echo $item['name']; ?>
</td>


<td>
<?php echo $item['vendor_name']; ?>
</td>


<td>
<?php echo $item['quantity']; ?>
</td>


<td>
<?php echo $item['unit_price']; ?>
</td>


</tr>


<?php

}

?>

</table>


<h3>
Total:
<?php echo $total; ?>
</h3>



<h3>Payment</h3>


<?php

$pay=$payment->fetch_assoc();

?>


<p>
Method:
<?php echo $pay['payment_method']; ?>
</p>


<p>
Transaction ID:
<?php echo $pay['transaction_id']; ?>
</p>



<button onclick="window.print()">
Print
</button>


</body>

</html>