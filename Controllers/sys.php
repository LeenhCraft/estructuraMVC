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
            $id = intval($_SESSION['lnh_id']);
            $requestUser = $this->model->first_time($id);
        }
        return $requestUser;
    }

    public function publi_first()
    {
        $requestUser['primera'] = 0;
        if (isset($_SESSION['pe_u'])) {
            $id = intval($_SESSION['pe_u']);
            $requestUser = $this->model->public_first_time($id);
        }
        return $requestUser;
    }
}
