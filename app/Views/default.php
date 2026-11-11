<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title> <?= $this->renderSection("title") ?></title>
</head>

<style>
	body {
		margin: 0;
	}

	nav a {
		color: white;
	}

	.book-form {
		display: flex;
		flex-direction: column;
		gap: 10px;
		padding: 0 20px;

	}

	.text-field {
		display: flex;
		flex-direction: column;

	}

	.book-form button {
		align-self: flex-end;
		width: fit-content;
		padding: 2px 8px;
	}

	label.required::after {
		content: "*";
		color: red;
	}

	.image {
		display: flex;
		flex-direction: row;
		justify-content: center;
		gap: 20px;
	}
</style>

<body>
	<nav style="position: sticky; top: 0; background-color: #202020; display: flex; align-items: center; gap: 20px; padding: 10px; color: white;">
		<h2 style="margin: 0;">Library</h2>
		<a href="<?= site_url('books') ?>">
			List of Books
		</a>
		<a href="<?= site_url('books/add/') ?>">Add Book</a>
	</nav>

	<?= $this->renderSection("content") ?>

</body>

</html>
