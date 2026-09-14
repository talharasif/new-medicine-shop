<?php

class CategoryController extends BaseController
{
    private Category $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Category($this->db);
    }

    private function page(?array $edit = null, array $errors = []): array
    {
        return [
            'rows' => $this->model->all(),
            'edit' => $edit,
            'errors' => $errors
        ];
    }

    public function index(): void
    {
        $this->view('categories/index', $this->page());
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->view('categories/index', $this->page($this->model->find($id)));
    }

    public function save(): void
    {
        if (!verifyCsrf()) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $type = (string)($_POST['category_type'] ?? '');
        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Name is required.';
        }

        if (!in_array($type, ['liquid', 'solid'], true)) {
            $errors['category_type'] = 'Choose liquid or solid.';
        }

        if ($errors) {
            $this->view('categories/index', $this->page($_POST, $errors));
            return;
        }

        try {
            $this->model->save($id > 0 ? $id : null, $name, $type);
            $this->flash($id > 0 ? 'Category updated.' : 'Category added.');
            $this->redirect('categories');
        } catch (Throwable $e) {
            $this->view('categories/index', $this->page($_POST, [
                'general' => $e->getMessage()
            ]));
        }
    }

    public function delete(): void
    {
        if (!verifyCsrf()) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        try {
            $this->model->delete((int)($_POST['id'] ?? 0));
            $this->flash('Category deleted.');
        } catch (Throwable $e) {
            $this->flash($e->getMessage());
        }

        $this->redirect('categories');
    }
}
