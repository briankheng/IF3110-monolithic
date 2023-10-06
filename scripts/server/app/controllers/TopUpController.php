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
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $data['username'] = $_POST['username'];
        $data['amount'] = $_POST['amount'];
        $data['status'] = $_POST['status'];

        $user = $this->model('UserModel')->getUserByUsername($data['username']);

        // Check if user exists
        if (!$user) {
            return json_response_fail("User not found!");
        }
        $data['idUser'] = $user['id'];

        // Add amount to user's balance if status is 1
        if ($data['status'] == 1) {
            $this->model('UserModel')->addUserBalance($user['id'], $data['amount']);
        }

        // Get current date
        $data['date'] = date('Y-m-d');

        if ($this->model('TopUpModel')->createTopUp($data)) {
            json_response_success("Top up created successfully!");
        } else {
            json_response_fail("Failed to create top up!");
        }
    }

    public function getTopUpRequested() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        if (!isset($_SESSION['user_id'])) {
            return json_response_fail(NOT_LOGGED_IN);
        }

        $data = $_SESSION['user_id'];
        $res = $this->model('TopUpModel')->getTopUpRequested($data);

        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(TOPUP_REQ_NOT_FOUND);
        }
    }

    public function getTopUpHistory() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        if (!isset($_SESSION['user_id'])) {
            return json_response_fail(NOT_LOGGED_IN);
        }

        $data = $_SESSION['user_id'];
        $res = $this->model('TopUpModel')->getTopUpHistory($data);

        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(TOPUP_HIST_NOT_FOUND);
        }
    }

    public function createTopUpRequest() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        if (!$_SESSION['user_id']) {
            return json_response_fail(NOT_LOGGED_IN);
        }

        $data = $_SESSION['user_id'];
        $res = $this->model('TopUpModel')->createTopUpRequest($data, $_POST['amount']);

        if ($res) {
            json_response_success($res);
        } else {
            json_response_fail(TOPUP_CREATION_FAILED);
        }
    }

    public function approveTopUp($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return json_response_fail(INVALID_REQUEST_METHOD);
        }

        $data['id'] = $id;
        $data['status'] = 1;

        // Add amount to user's balance
        $topUp = $this->model('TopUpModel')->getTopUpById($id);
        $this->model('UserModel')->addUserBalance($topUp['user_id'], $topUp['amount']);

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