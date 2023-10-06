<?php

class TopUpController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllTopUps() {
        $topUps = $this->model('TopUpModel')->getAllTopUps();

        json_response_success($topUps);
    }

    public function getTopUpById($id) {
        $topUp = $this->model('TopUpModel')->getTopUpById($id);

        json_response_success($topUp);
    }

    public function getTopUpsByPage($page) {
        $topUps = $this->model('TopUpModel')->getTopUpsByPage($page);

        json_response_success($topUps);
    }

    public function createTopUp() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['idUser'] = $_POST['idUser'];
        $data['amount'] = $_POST['amount'];
        $data['status'] = $_POST['status'];

        // Get current date
        $data['date'] = date('Y-m-d');

        if ($this->model('TopUpModel')->createTopUp($data)) {
            json_response_success("Top up created successfully!");
        } else {
            json_response_fail("Failed to create top up!");
        }
    }

    public function approveTopUp($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['id'] = $id;
        $data['status'] = 1;

        if ($this->model('TopUpModel')->editTopUp($data)) {
            json_response_success("Top up approved successfully!");
        } else {
            json_response_fail("Failed to approve top up!");
        }
    }

    public function rejectTopUp($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['id'] = $id;
        $data['status'] = 2;

        if ($this->model('TopUpModel')->editTopUp($data)) {
            json_response_success("Top up rejected successfully!");
        } else {
            json_response_fail("Failed to reject top up!");
        }
    }

    public function deleteTopUp($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        if ($this->model('TopUpModel')->deleteTopUp($id)) {
            json_response_success("Top up deleted successfully!");
        } else {
            json_response_fail("Failed to delete top up!");
        }
    }
}