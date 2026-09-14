<?php require __DIR__."/../layouts/header.php"; ?>
<h1>Customer Information</h1>
<div class="details-card">
<p><b>Customer ID:</b> <?=e($customer['id'])?></p><p><b>Name:</b> <?=e($customer['name'])?></p>
<p><b>Email:</b> <?=e($customer['email'])?></p><p><b>Phone:</b> <?=e($customer['phone'])?></p>
<p><b>Address:</b> <?=e($customer['address'])?></p><p><b>Joined:</b> <?=e($customer['created_at'])?></p>
<p><b>Total Orders:</b> <?=e($customer['total_orders'])?></p><p><b>Accepted Purchase Total:</b> <?=e($customer['total_purchase'])?></p>
</div>
<h2>Customer Orders</h2>
<table><tr><th>Order ID</th><th>Total</th><th>Status</th><th>Address</th><th>Date</th></tr>
<?php foreach($orders as $o): ?><tr><td>#<?=$o['id']?></td><td><?=e($o['total_amount'])?></td><td><?=e($o['status'])?></td><td><?=e($o['shipping_address'])?></td><td><?=e($o['order_date'])?></td></tr><?php endforeach; ?></table>
<p><a class="btn-link" href="index.php?action=customers">← Back to Customers</a></p>
<?php require __DIR__."/../layouts/footer.php"; ?>
