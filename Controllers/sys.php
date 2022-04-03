<?php
class sys extends Controllers
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function first_time()
    {
        $requestUser['primera'] = 0;
        if (isset($_SESSION['lnh_id'])) {
            $requestUser = $this->model->first_time();
        }
        return $requestUser;
    }

    public function demo()
    {
        // $this->views->getView('Errors', "404");
        if (isset($_SESSION)) {
            dep("dentro");
        } else {
            dep("fuera");
        }
    }
}
