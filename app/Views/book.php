<?= $this->extend("default") ?>
<?= $this->section("title") ?>Add/Edit Book<?= $this->endSection() ?>

<?= $this->section("content") ?>

<body>
	<?php helper('form'); ?>
	<?php $book ??= null; ?>
	<?php $editing = $book !== null; ?>
	<h1>
		<?= $editing ? 'Edit Book' : 'Add Book' ?>
	</h1>

	<?= validation_list_errors() ?>

	<?= form_open_multipart($editing ? site_url("books/edit/" . $book['id']) : site_url('books/add'), ['class' => 'book-form']) ?>

	<?= csrf_field() ?>

	<div class="text-field">
		<label class="required" for="">Title</label>
		<input type="text" name="title" placeholder="eg. Frankenstein" value="<?= set_value('title', $book['title'] ?? '') ?>">
	</div>
	<div class="text-field">
		<label class="required" for="">Author Name</label>
		<input type="text" name="author" placeholder="eg. Mary Shelly" value="<?= set_value('author', $book['author'] ?? '') ?>">

	</div>

	<div class="text-field">
		<label for="">Genre</label>
		<input type="text" name="genre" placeholder="eg. Horror" value="<?= set_value('genre', $book['genre'] ?? '') ?>">
	</div>

	<div class="text-field">
		<label class="required" for="">Publication Year</label>
		<input type="text" name="publication_year" placeholder="eg. 1818" value="<?= set_value('publication_year', $book['publication_year'] ?? '') ?>">
	</div>

	<div class="image">
		<?php if (! empty($book['image'])): ?>
			<div style="display: flex; flex-direction: column; align-items: center; ">
				<h3>Current Image: </h3>
				<img width="100px" src="<?= base_url('uploads/' . $book['image']) ?>" alt="">
				<p><?= esc($book['image']) ?></p>

				<label>
					<input type="checkbox" name="remove-image" id="remove-image" value="1"> Remove current image
				</label>
			</div>



		<?php endif ?>
		<div>
			<h3><?= esc(! empty($book['image']) ? 'Change image:' : 'Choose new image:') ?></h3>
			<input id="image-input" type="file" name="image" accept="image/*">
		</div>

	</div>

	<script>
		const removeBox = document.getElementById('remove-image');
		const fileInput = document.getElementById('image-input');

		if (removeBox && fileInput) {
			removeBox.addEventListener('change', () => {
				fileInput.disabled = removeBox.checked;
				if (removeBox.checked) fileInput.value = '';
			});
		}
	</script>

	<button type="submit"><?= $editing ? 'Update' : 'Save' ?></button>

	<?= form_close() ?>
</body>

<?= $this->endSection() ?>
