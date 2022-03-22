<?php
class Dashboard extends Controllers
{
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url());
        }
        parent::__construct();
    }

    public function dashboard()
    {
        $data['titulo_web'] = 'Biblio Web';
        $this->views->getView($this, "dashboard", $data);
    }

    public function demo()
    {
        dep(strtolower(get_class($this)));
        menus();
    }
}
