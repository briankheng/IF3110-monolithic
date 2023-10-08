<?php

class App {
    protected $params = [];
    public function __construct() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        } else {
            header('Access-Control-Allow-Origin: *');
        }

        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        session_start();

        $url = $this->parseUrl();
        if (isset($url[0]) && file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
        } else {
            echo json_encode(Array('status' => false, 'message' => "api_not_found"));
            return;
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        } else {
            $this->method = $url[0];
        }
        unset($url[0]);

        if (!empty($url)) {
            $this->params = array_values($url);
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST == null) {
                $_POST = json_decode(file_get_contents('php://input'), true);
            }            
        }

        if (isset($_SESSION['user_id'])) {
            $this->user = $_SESSION['user_id'];
            $this->role = $_SESSION['role'];
        }

        // Implement logic to check user already login or not
        if (!$this->checkLogin()) {
            http_response_code(403); // Forbidden status code
            echo json_encode(['status' => false, 'message' => 'You need to login first', 'location' => '/pages/login']);
            return;
        }

        // Implement logic for role-based access controller
        if (!$this->checkAccess()) {
            http_response_code(403); // Forbidden status code
            echo json_encode(['status' => false, 'message' => 'You are not allowed to access this page', 'location' => '/pages/home']);
            return;
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function checkLogin() {
        $accessControl1 = [
            // Define the allowed ednpoint for unloggedin user
            'ProductController' => [
                'showAllProducts', 'queryProduct', 'getProduct'
            ],
            'CategoryController' => [
                'showAllcategories'
            ],
            'Auth' => [
                'info', 'login', 'signup'
            ]
        ];        

        $controllerName1 = get_class($this->controller);

        if (isset($accessControl1[$controllerName1]) && in_array($this->method, $accessControl1[$controllerName1])) {
            if (!isset($_SESSION['user_id'])) {
                return true;
            } else {
                return true;
            }
        } else {
            // If the method is not explicitly restricted, restrict
            if (isset($_SESSION['user_id'])) {
                return true;
            } else {
                return false;
            }
        }
    }

    protected function checkAccess() {
        $accessControl = [
            // Define the only admin method controller
            'ProductController' => [
                'getAllProducts', 'getProductsByPage', 'deleteProduct', 'createProduct', 'editProduct'
            ],
            'TopUpController' => [
                'getAllTopUps', 'getTopUpsByPage', 'createTopUp', 'approveTopUp', 'rejectTopUp', 'deleteTopUp'
            ],
            'UserController' => [
                'getAllUsers', 'getUsersByPage', 'createUser', 'deleteUser'
            ],
        ];

        $controllerName = get_class($this->controller);

        if (isset($accessControl[$controllerName]) && in_array($this->method, $accessControl[$controllerName])) {
            if (isset($this->role) && $this->role === 'admin') {
                // Admin has access to the method
                return true;
            } else {
                // User doesn't have access to the method
                return false;
            }
        }

        // If the method is not explicitly restricted, allow access
        return true;
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}