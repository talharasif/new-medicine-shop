<?php

include "../control/order_control.php";

?>


<html>

<head>

<title>Order Details</title>

</head>


<body>


<h2>Order Details</h2>


<?php

$orderData=$order->fetch_assoc();

?>


<p>
Order ID:
<?php echo $orderData['id']; ?>
</p>


<p>
Date:
<?php echo $orderData['order_date']; ?>
</p>


<p>
Total:
<?php echo $orderData['total_amount']; ?>
</p>


<p>
Status:
<?php echo $orderData['status']; ?>
</p>


<h3>Order Tracking</h3>


<?php

if($orderData['status']=="pending")
{

echo "⏳ Pending Admin Approval";

}
elseif($orderData['status']=="accepted")
{

echo "✅ Order Accepted";

}
else
{

echo "❌ Order Rejected";

}

?>



<?php

if($orderData['status']=="pending")

{

?>

<br><br>

<a href="../control/order_control.php?cancel=<?php echo $orderData['id']; ?>"
onclick="return confirm('Cancel this order?')">

Cancel Order

</a>


<?php

}

?>


<br><br>

<a href="../control/order_control.php?reorder=<?php echo $orderData['id']; ?>">

Reorder

</a>

<h3>Medicines</h3>


<table border="1">


<tr>

<th>Name</th>
<th>Vendor</th>
<th>Quantity</th>
<th>Price</th>

</tr>


<?php

while($item=$items->fetch_assoc())

{

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


<br>

<a href="order_history.php">
Back
</a>



<br><br>

<a href="invoice.php?invoice=<?php echo $orderData['id']; ?>">
Print Invoice
</a>

</body>

</html>