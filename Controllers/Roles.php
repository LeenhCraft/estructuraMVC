<?php
class Roles extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function roles()
    {
        $data['titulo_web']   = "Roles - Biblio Web 2.0";
        $this->views->getView('App/Roles', "roles", $data);
    }
}
