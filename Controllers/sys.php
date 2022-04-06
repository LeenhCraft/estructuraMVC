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
}
