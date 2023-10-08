<?php

class HistoryController extends Controller {

    public function getTopUpHistory() {
        $data = $_SESSION['user_id'];
        $topUpHistory = $this->model('HistoryModel')->getAllTopUpHistory($data);

        json_response_success($topUpHistory);
    }

    public function getBuyHistory() {
        $data = $_SESSION['user_id'];
        $buyHistory = $this->model('HistoryModel')->getAllBuyHistory($data);
    
        json_response_success($buyHistory);
    }
}
