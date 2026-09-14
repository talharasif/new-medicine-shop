<?php
class DashboardController extends BaseController {
    public function index(): void {
        $dash=new Dashboard($this->db);
        $orders=new Order($this->db);
        $this->view("dashboard/index",[
            'counts'=>$dash->counts(),
            'recentCustomers'=>$dash->recentCustomers(),
            'lowStock'=>$dash->lowStock(),
            'recentOrders'=>$orders->recent(5)
        ]);
    }
}
