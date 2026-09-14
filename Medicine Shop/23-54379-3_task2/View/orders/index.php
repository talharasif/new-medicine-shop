<?php require __DIR__."/../layouts/header.php"; ?>
<h1>Purchase Requests</h1>
<div class="toolbar"><input id="orderSearch" placeholder="Search order ID, customer or email">
<select id="orderStatusFilter"><option value="all">All Status</option><option value="pending">Pending</option><option value="accepted">Accepted</option><option value="rejected">Rejected</option></select></div>
<table id="ordersTable" data-csrf="<?=csrfToken()?>"><thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Address</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
<tbody><?php foreach($rows as $r): ?><tr data-order="<?=$r['id']?>">
<td><?=$r['id']?></td><td><?=e($r['customer_name'])?><br><small><?=e($r['email'])?></small></td><td><?=e($r['total_amount'])?></td>
<td><?=e($r['shipping_address'])?></td><td><?=e($r['order_date'])?></td><td class="status"><?=e($r['status'])?></td>
<td><?php if($r['status']==='pending'): ?><button class="status-btn" data-status="accepted">Accept</button><button class="status-btn danger" data-status="rejected">Reject</button><?php else: ?>Processed<?php endif; ?></td>
</tr><?php endforeach; ?></tbody></table>
<?php require __DIR__."/../layouts/footer.php"; ?>
