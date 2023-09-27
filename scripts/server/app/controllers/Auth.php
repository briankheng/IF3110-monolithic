<?php

class Auth extends Controller {
    public function login() {
        
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