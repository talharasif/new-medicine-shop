<?php require __DIR__.'/../layouts/header.php'; ?>
<h1>Edit Customer</h1>
<form method="post" action="index.php?action=customer_save" class="form">
<input type="hidden" name="csrf_token" value="<?=csrfToken()?>"><input type="hidden" name="id" value="<?=e($customer['id'])?>">
<label>Name<input name="name" required value="<?=e($customer['name'])?>"></label>
<label>Email<input type="email" name="email" required value="<?=e($customer['email'])?>"></label>
<label>Phone<input name="phone" value="<?=e($customer['phone'])?>"></label>
<label>Address<textarea name="address"><?=e($customer['address'])?></textarea></label>
<button type="submit">Save Changes</button> <a class="btn-link" href="index.php?action=customers">Cancel</a>
</form>
<?php require __DIR__.'/../layouts/footer.php'; ?>