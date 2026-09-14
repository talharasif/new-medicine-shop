<?php require __DIR__."/../layouts/header.php"; ?>
<h1>Admin Dashboard</h1>
<div class="cards"><?php foreach($counts as $k=>$v): ?><div class="card"><h3><?=e(ucwords(str_replace("_"," ",$k)))?></h3><strong><?=$v?></strong></div><?php endforeach; ?></div>
<div class="dashboard-grid">
<section><h2>Recent Purchase Requests</h2><table><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr>
<?php foreach($recentOrders as $o): ?><tr><td>#<?=$o['id']?></td><td><?=e($o['customer_name'])?></td><td><?=e($o['total_amount'])?></td><td><?=e($o['status'])?></td></tr><?php endforeach; ?></table></section>
<section><h2>Low Stock Medicines</h2><table><tr><th>Medicine</th><th>Stock</th></tr>
<?php if($lowStock): foreach($lowStock as $m): ?><tr><td><?=e($m['name'])?></td><td><?=e($m['availability'])?></td></tr><?php endforeach; else: ?><tr><td colspan="2">No low-stock medicines.</td></tr><?php endif; ?></table></section>
<section><h2>Recent Customers</h2><table><tr><th>Name</th><th>Email</th><th>Joined</th></tr>
<?php foreach($recentCustomers as $c): ?><tr><td><?=e($c['name'])?></td><td><?=e($c['email'])?></td><td><?=e($c['created_at'])?></td></tr><?php endforeach; ?></table></section>
</div>
<?php require __DIR__."/../layouts/footer.php"; ?>
