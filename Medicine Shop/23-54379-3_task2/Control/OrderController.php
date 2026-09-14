<?php

class OrderController extends BaseController
{
    private Order $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Order($this->db);
    }

    public function index(): void
    {
        $this->view('orders/index', [
            'rows' => $this->model->all()
        ]);
    }

    public function history(): void
    {
        $this->view('history/index', [
            'rows' => $this->model->acceptedHistory()
        ]);
    }

    public function searchApi(): never
    {
        header('Content-Type: application/json; charset=utf-8');

        $q = trim($_GET['q'] ?? '');
        $status = (string)($_GET['status'] ?? 'all');

        echo json_encode([
            'success' => true,
            'rows' => $this->model->search($q, $status)
        ]);

        exit;
    }

    public function updateStatusApi(): never
    {
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $token = (string)($input['csrf_token'] ?? '');

        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid CSRF token'
            ]);
            exit;
        }

        try {
            $ok = $this->model->updateStatus(
                (int)($input['id'] ?? 0),
                (string)($input['status'] ?? '')
            );

            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Order updated.' : 'Order was already processed or not found.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }
}
