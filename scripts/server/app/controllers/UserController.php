<?php

class UserController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAllUsers() {
        $users = $this->model('UserModel')->getAllUsers();

        json_response_success($users);
    }

    public function getUserById($id) {
        $user = $this->model('UserModel')->getUserById($id);

        json_response_success($user);
    }

    public function getUsersByPage($page) {
        $users = $this->model('UserModel')->getUsersByPage($page);

        json_response_success($users);
    }

    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $data['username'] = $_POST['username'];
        $data['password'] = $_POST['password'];
        $data['name'] = $_POST['name'];
        $data['role'] = "user";
        $data['balance'] = $_POST['balance'];

        // Hashing password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->model('UserModel')->createUser($data)) {
            json_response_success("User created successfully!");
        } else {
            json_response_fail("Failed to create user!");
        }
    }

    public function editUser() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        $data['id'] = $_POST['id'];
        $data['username'] = $_POST['username'];
        $data['password'] = $_POST['password'];
        $data['name'] = $_POST['name'];
        $data['balance'] = $_POST['balance'];

        // Check if username exists
        $user = $this->model('UserModel')->getUserByUsername($data['username']);
        if ($user && $user['id'] != $data['id']) {
            return json_response_fail("Username already exists!");
        }

        // Hashing password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->model('UserModel')->editUser($data)) {
            json_response_success("User updated successfully!");
        } else {
            json_response_fail("Failed to edit user!");
        }
    }

    public function deleteUser($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return json_response_fail(METHOD_NOT_ALLOWED);
        }

        if ($this->model('UserModel')->deleteUser($id)) {
            json_response_success("User deleted successfully!");
        } else {
            json_response_fail("Failed to delete user!");
        }
    }
}