<?php
class Dashboard extends Controllers
{
    private $permisos;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
    }

    public function dashboard()
    {
        $data['titulo_web'] = 'Biblio Web';
        $data['permisos'] = $this->permisos;
        $this->views->getView('App/Dashboard', "dashboard", $data);
    }

    public function demo()
    {
        dep(strtolower(get_class($this)));
        dep(password_hash(321321, PASSWORD_DEFAULT));
        dep(getPermisos(get_class($this)));
        dep(submenus(1));
    }
}
