<?php require __DIR__."/../layouts/header.php"; ?>
<h1>Customer Management</h1>
<div class="toolbar"><input id="customerSearch" placeholder="Search by name, email, phone or address"></div>
<table id="customersTable" data-csrf="<?=csrfToken()?>"><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?><tr>
<td><?=e($r['name'])?></td><td><?=e($r['email'])?></td><td><?=e($r['phone'])?></td><td><?=e($r['address'])?></td>
<td><a class="btn-link" href="index.php?action=customer_details&id=<?=$r['id']?>">View</a>
<form class="inline" method="post" action="index.php?action=customer_delete" data-confirm="Delete customer and related records?"><input type="hidden" name="csrf_token" value="<?=csrfToken()?>"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="danger">Delete</button></form></td>
</tr><?php endforeach; ?>
</tbody></table>
<?php require __DIR__."/../layouts/footer.php"; ?>
