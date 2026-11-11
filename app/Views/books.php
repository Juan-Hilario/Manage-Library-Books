<?= $this->extend("default") ?>
<?= $this->section("title") ?>List of Books<?= $this->endSection() ?>

<?= $this->section("content") ?>
<h1>List of Books</h1>


<?php if (session('message')): ?>
	<div class="message" style="background-color:rgb(0, 200, 100); display:flex; flex-direction: row;justify-content: space-between; padding: 10px 8px;">
		<span><?= esc(session('message')) ?></span>
		<button onclick="this.parentElement.remove()">&times;</button>
	</div>
<?php endif ?>

<?php if (count($books) !== 0): ?>
	<table style="background-color: rgba(0, 0, 0, .1); width: 100%; text-align: center;">

		<tr style="background-color:rgb(0,200,255)">
			<th>Title</td>
			<th>Author</td>
			<th>Genre</td>
			<th>Publication Year</td>
			<th>Options</td>
		</tr>

		<?php foreach ($books as $book): ?>
			<tr class="book">
				<td><img src="<?= base_url(! empty($book['image']) ? 'uploads/' . $book['image'] : 'images/default_image.jpg') ?>"
						alt="Cover of <?= esc($book['title'], 'attr') ?>" width="60"></td>
				<td><?= esc($book['title']) ?></td>
				<td><?= esc($book['author']) ?></td>
				<td><?= esc($book['genre']) ?></td>
				<td><?= esc($book['publication_year']) ?></td>
				<td style="background-color: none;">
					<div style="display: flex; flex-direction: row; justify-content: center;">
						<form method="get" action="<?= site_url('books/edit/' . $book['id']) ?>">
							<?= csrf_field() ?>
							<button type="submit">edit</button>
						</form>
						<form method="post" action="<?= site_url('books/delete/' . $book['id']) ?>"
							data-title=" <?= esc($book['title'], 'attr') ?>"
							onsubmit="return confirm(`Are you sure you want to delete &quot;${this.dataset.title}&quot;?`);">
							<?= csrf_field() ?>
							<button type="submit">delete</button>
						</form>
					</div>
				</td>

			</tr>

		<?php endforeach ?>

	</table>
<?php else: ?>
	<div style="display: flex; flex-direction: column; align-items: center;">
		<h3>The library is empty.</h3>
		<p>Use the <a href="<?= site_url('books/add/') ?>">add</a> form page to add books to the libray.</p>

	</div>

<?php endif ?>

<?= $this->endSection() ?>
