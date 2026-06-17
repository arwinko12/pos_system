<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1>Update Product Image</h1>

<p class="lead">Product Name: <?= esc($product['product_name']) ?></p> 

<a href="<?= base_url('admin/products') ?>" class="btn mb-3 btn-secondary">Back</a>

	
	<?= form_open_multipart('upload/upload') ?>
	<input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
    <input type="file" class="form-control" name="userfile" size="20">
    <br><br>
    <input type="submit" class="btn btn-primary" value="Upload">
	</form>


<?= $this->endSection() ?>