<?php

class MedicineController extends BaseController
{
    private Medicine $model;
    private Category $cats;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Medicine($this->db);
        $this->cats = new Category($this->db);
    }

    private function page(?array $edit = null, array $errors = []): array
    {
        return [
            'rows' => $this->model->all(),
            'categories' => $this->cats->all(),
            'edit' => $edit,
            'errors' => $errors
        ];
    }

    public function index(): void
    {
        $this->view('medicines/index', $this->page());
    }

    public function details(): void
    {
        $medicine = $this->model->details((int)($_GET['id'] ?? 0));

        if (!$medicine) {
            http_response_code(404);
            exit('Medicine not found');
        }

        $this->view('medicines/details', ['medicine' => $medicine]);
    }

    public function searchApi(): never
    {
        header('Content-Type: application/json; charset=utf-8');

        $q = trim($_GET['q'] ?? '');
        $category = (string)($_GET['category'] ?? '');
        $type = (string)($_GET['type'] ?? '');

        echo json_encode([
            'success' => true,
            'rows' => $this->model->search($q, $category, $type)
        ]);

        exit;
    }

    private function upload(): ?string
    {
        if (empty($_FILES['image']['name'])) {
            return null;
        }

        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Image upload failed.');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new RuntimeException('Image must be 2MB or less.');
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        if (!isset($map[$mime])) {
            throw new RuntimeException('Only JPEG and PNG images are allowed.');
        }

        $name = bin2hex(random_bytes(12)) . '.' . $map[$mime];
        $dir = __DIR__ . '/../public/uploads/medicines/';

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $dir . $name)) {
            throw new RuntimeException('Could not save image.');
        }

        return 'uploads/medicines/' . $name;
    }

    public function save(): void
    {
        if (!verifyCsrf()) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'vendor_name' => trim($_POST['vendor_name'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'availability' => (int)($_POST['availability'] ?? -1),
            'description' => trim($_POST['description'] ?? ''),
            'image_path' => null
        ];

        $errors = [];

        if ($data['name'] === '') $errors['name'] = 'Name is required.';
        if ($data['category_id'] <= 0) $errors['category_id'] = 'Category is required.';
        if ($data['vendor_name'] === '') $errors['vendor_name'] = 'Vendor is required.';
        if ($data['price'] <= 0) $errors['price'] = 'Price must be greater than 0.';
        if ($data['availability'] < 0) $errors['availability'] = 'Stock cannot be negative.';

        if ($errors) {
            $this->view('medicines/index', $this->page($_POST, $errors));
            return;
        }

        try {
            $data['image_path'] = $this->upload();

            if ($id > 0) {
                $this->model->update($id, $data);
                $this->flash('Medicine updated.');
            } else {
                $this->model->create($data);
                $this->flash('Medicine added.');
            }

            $this->redirect('medicines');
        } catch (Throwable $e) {
            $this->view('medicines/index', $this->page($_POST, [
                'general' => $e->getMessage()
            ]));
        }
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->view('medicines/index', $this->page($this->model->find($id)));
    }

    public function delete(): void
    {
        if (!verifyCsrf()) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        try {
            $this->model->delete((int)($_POST['id'] ?? 0));
            $this->flash('Medicine deleted.');
        } catch (Throwable $e) {
            $this->flash($e->getMessage());
        }

        $this->redirect('medicines');
    }
}
