<?php require __DIR__."/../layouts/header.php"; ?>
<h1>Medicine Information</h1>
<div class="details-card medicine-detail">
<?php if($medicine['image_path']): ?><img class="detail-image" src="<?=e($medicine['image_path'])?>"><?php endif; ?>
<div>
<p><b>Medicine:</b> <?=e($medicine['name'])?></p><p><b>Category:</b> <?=e($medicine['category_name'])?></p>
<p><b>Type:</b> <?=e($medicine['category_type'])?></p><p><b>Vendor:</b> <?=e($medicine['vendor_name'])?></p>
<p><b>Price:</b> <?=e($medicine['price'])?></p><p><b>Available Stock:</b> <?=e($medicine['availability'])?></p>
<p><b>Description:</b> <?=e($medicine['description'])?></p><p><b>Added:</b> <?=e($medicine['created_at'])?></p>
</div></div>
<p><a class="btn-link" href="index.php?action=medicines">← Back to Medicines</a></p>
<?php require __DIR__."/../layouts/footer.php"; ?>
