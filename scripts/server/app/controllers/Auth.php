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
            
            if ($this->model('UserModel')->signup($data)) {
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
    
            $user = $this->model('UserModel')->getPassword($username);
            if ($user === false) {
                echo "Username not found.\n";
                return;
            }
            $true_password = $user['password'];
            if (password_verify($password, $true_password)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
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
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION["user_id"])) {
            $user_data = $this->model('UserModel')->getUserById($_SESSION["user_id"]);
            json_response_success($user_data);
        } else {
            json_response_fail(NOT_LOGGED_IN);
        }
    }

    public function getInfo() {
        $user = $this->model('UserModel')->getUserInfo($_SESSION['user_id']);
        echo json_encode($user);
    }

    public function changeAccSettings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $id = $_SESSION['user_id'];
    
            $data = [
                'name' => $name,
                'password' => $password,
                'id' => $id
            ];
    
            $user = $this->model('UserModel')->changeAccountSettings($data);
        }     
    } 
}