<?php


include "../control/medicine_control.php";


?>


<html>

<head>

<title>Medicine Details</title>

</head>


<body>

<div class="details">

<h2>Medicine Details</h2>


<?php

$data=$medicine->fetch_assoc();

?>


<p>
Name:
<?php echo $data['name']; ?>
</p>


<p>
Category:
<?php echo $data['category_name']; ?>
</p>


<p>
Type:
<?php echo $data['category_type']; ?>
</p>


<p>
Vendor:
<?php echo $data['vendor_name']; ?>
</p>


<p>
Price:
<?php echo $data['price']; ?>
</p>


<p>
Stock:
<?php echo $data['availability']; ?>
</p>


<p>
Description:
<?php echo $data['description']; ?>
</p>

</div>

</body>

</html>