<?php

include "../control/order_control.php";

?>


<html>

<head>

<title>Order History</title>


<link rel="stylesheet" href="../css/mycss.css">


<script src="../js/myjs.js"></script>


</head>



<body>



<div class="card">


<h2>
Welcome Customer
</h2>


<p>
Here you can view your medicine orders.
</p>


</div>





<h3>My Orders</h3>





<div class="card">


<input 
type="text" 
id="search" 
placeholder="Search Order ID">



<button onclick="searchOrder()">

Search

</button>


</div>






<div class="card">


<table>


<tr>


<th>
Order ID
</th>


<th>
Date
</th>


<th>
Total
</th>


<th>
Status
</th>


<th>
Action
</th>


</tr>



<tbody id="orderData">



<?php


while($row=$result->fetch_assoc())

{


?>



<tr>


<td>

<?php echo $row['id']; ?>

</td>



<td>

<?php echo $row['order_date']; ?>

</td>



<td>

<?php echo $row['total_amount']; ?>

</td>



<td>

<?php echo $row['status']; ?>

</td>




<td>


<a href="order_details.php?id=<?php echo $row['id']; ?>">

View

</a>


</td>



</tr>




<?php

}


?>



</tbody>



</table>



</div>




</body>


</html>