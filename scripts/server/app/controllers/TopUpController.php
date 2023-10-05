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
        
    }

    public function editTopUp($id) {
        
    }

    public function deleteTopUp($id) {
        
    }
}