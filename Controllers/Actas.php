<?php
class Actas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function actas()
    {
        $data['titulo_web']   = "Actas- Biblio Web 2.0";
        $data['js'] = ['js/app/nw_actas.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Actas', "actas", $data);
    }
}
