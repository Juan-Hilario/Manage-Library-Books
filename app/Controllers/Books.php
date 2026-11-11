<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\BaseController;

class Books extends BaseController
{
	private array $fields = ['title', 'author', 'genre', 'publication_year'];

	private array $rules = [
		'title' => 'required|max_length[255]',
		'author' => 'required|max_length[255]',
		'genre' => 'permit_empty|max_length[100]',
		'publication_year' => 'required|integer|exact_length[4]',
		'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpeg,image/png,image/webp]|max_size[image,2048]',
	];

	public function index()
	{
		$books = (new BookModel())->orderBy('title')->findAll();
		return view('books', ['books' => $books]);
	}

	public function index_redirect()
	{
		return redirect()->to('/books');
	}

	public function addBook()
	{
		return view('book', ['book' => null]);
	}

	public function add()
	{
		if (! $this->validate($this->rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		if (! $this->validate($this->rules) || $this->uploadFailed()) {
			return redirect()->back()->withInput();
		}

		$data = $this->request->getPost($this->fields);

		if ($image = $this->saveImage()) {
			$data['image'] = $image;
		}

		(new BookModel())->insert($data);

		return redirect()->to('/books')->with('message', $data['title'] . ' added successfully!');
	}

	public function editBook($id)
	{
		$book = (new BookModel())->find($id);

		if ($book === null) {
			throw PageNotFoundException::forPageNotFound();
		}

		return view("book", ["book" => $book]);
	}

	public function edit($id)
	{
		$model = new BookModel();
		$book = $model->find($id);

		if ($book === null) {
			throw PageNotFoundException::forPageNotFound();
		}

		if (! $this->validate($this->rules) || $this->uploadFailed()) {
			return redirect()->back()->withInput();
		}

		if (! $this->validate($this->rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$data = $this->request->getPost($this->fields);

		if ($this->request->getPost('remove-image')) {
			$this->deleteImage($book['image']);
			$data['image'] = null;
		} elseif ($image = $this->saveImage()) {
			$this->deleteImage($book['image']);
			$data['image'] = $image;
		}


		$model->update($id, $data);

		return redirect()->to('/books')->with('message', $data['title'] . ' updated successfully!');
	}

	public function delete($id)
	{
		$model = new BookModel();
		$book = $model->find($id);

		if ($book === null) {
			throw PageNotFoundException::forPageNotFound();
		}

		$this->deleteImage($book['image']);
		$model->delete($id);

		return redirect()->to('/books')->with('message', $book["title"] . ' deleted successfully!');
	}

	private function saveImage(): ?string
	{
		$file = $this->request->getFile('image');

		if ($file && $file->isValid() && ! $file->hasMoved()) {
			$name = $file->getRandomName();
			$file->move(FCPATH . 'uploads', $name);
			return $name;
		}
		return null;
	}

	private function deleteImage(?string $name): void
	{
		if ($name && is_file(FCPATH . 'uploads/' . $name)) {
			unlink(FCPATH . 'uploads/' . $name);
		}
	}

	private function uploadFailed(): bool
	{
		$file = $this->request->getFile('image');

		if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE && ! $file->isValid()) {
			$this->validator->setError('image', $file->getErrorString());
			return true;
		}

		return false;
	}
}
