<?php

class HistoryController extends Controller {

    public function getTopUpHistory() {
        if (!$_SESSION['user_id']) {
            echo "NOT_LOGGED_IN";
            return;
        }
        $data = $_SESSION['user_id'];
        $topUpHistory = $this->model('History')->getAllTopUpHistory($data);

        json_response_success($topUpHistory);
    }

    public function getBuyHistory() {
        if (!$_SESSION['user_id']) {
            echo "NOT_LOGGED_IN";
            return;
        }
        $data = $_SESSION['user_id'];
        $buyHistory = $this->model('History')->getAllBuyHistory($data);
    
        json_response_success($buyHistory);
    }


}
