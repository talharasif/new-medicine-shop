<?php

class CustomerController extends BaseController
{
    private User $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new User($this->db);
    }

    public function index(): void
    {
        $this->view('customers/index', [
            'rows' => $this->model->customers()
        ]);
    }

    public function details(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $customer = $this->model->customerDetails($id);

        if (!$customer) {
            http_response_code(404);
            exit('Customer not found');
        }

        $this->view('customers/details', [
            'customer' => $customer,
            'orders' => $this->model->customerOrders($id)
        ]);
    }

    public function searchApi(): never
    {
        header('Content-Type: application/json; charset=utf-8');

        $q = trim($_GET['q'] ?? '');

        echo json_encode([
            'success' => true,
            'rows' => $this->model->searchCustomers($q)
        ]);

        exit;
    }

    public function edit(): void
    {
        $customer=$this->model->findCustomer((int)($_GET['id'] ?? 0));
        if(!$customer){ http_response_code(404); exit('Customer not found'); }
        $this->view('customers/edit',['customer'=>$customer]);
    }

    public function save(): void
    {
        if(!verifyCsrf()){ http_response_code(403); exit('Invalid CSRF token'); }
        $id=(int)($_POST['id'] ?? 0);
        $name=trim($_POST['name'] ?? '');
        $email=trim($_POST['email'] ?? '');
        $phone=trim($_POST['phone'] ?? '');
        $address=trim($_POST['address'] ?? '');
        if($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL)){ exit('Valid name and email are required.'); }
        $this->model->updateCustomer($id,$name,$email,$phone,$address);
        $this->flash('Customer updated.'); $this->redirect('customers');
    }

    public function delete(): void
    {
        if (!verifyCsrf()) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }

        try {
            $this->model->deleteCustomer((int)($_POST['id'] ?? 0));
            $this->flash('Customer deleted.');
        } catch (Throwable $e) {
            $this->flash($e->getMessage());
        }

        $this->redirect('customers');
    }
}
