<?php
class Dashboard extends Controllers
{
    private $permisos;

    public function __construct()
    {
        // session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
    }

    public function dashboard()
    {
        $data['titulo_web'] = 'Biblio Web';
        // if ($primera['primera'] == '0') {
        $data['permisos'] = $this->permisos;
        $data['primera'] = $this->model->first_time();
        $this->views->getView('App/Dashboard', "dashboard", $data);
        // } else {
        //     $this->views->getView('App/Dashboard', "cambiar_pass", $data);
        // }
    }

    public function demo()
    {
        // dep(strtolower(get_class($this)));
        // dep(password_hash(321321, PASSWORD_DEFAULT));
        // dep(getPermisos(get_class($this)));
        // dep($_SESSION);     
        $this->views->getView('Errors', "404");
    }
}
