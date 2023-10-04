<?php

class Auth extends Controller {
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Hashing
            $password = password_hash($password, PASSWORD_DEFAULT);
            $name = $_POST['name'];
            $role = $_POST['role'];

            $data['username'] = $_POST['username'];
            $data['password'] = $password;
            $data['name'] = $_POST['name'];
            $data['role'] = $_POST['role'];
            
            if ($this->model('Users')->signup($data)) {
                json_response_success("success");
            } else {
                json_response_fail("fail");
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = $this->model('Users')->getPassword($username);
            if ($user === false) {
                echo "Username not found.\n";
                return;
            }
            $true_password = $user['password'];
            if (password_verify($password, $true_password)) {
                $_SESSION['user_id'] = $user['id'];
                echo "Login successful.";

            } else {
                echo "Invalid username or password.\n";
            }
        }     
    }

    public function logout() {
        session_destroy();
        json_response_success("success");
    }

    public function info() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION["user"])) {
            json_response_success($_SESSION["user"]);
        } else {
            json_response_fail(NOT_LOGGED_IN);
        }
    }

}