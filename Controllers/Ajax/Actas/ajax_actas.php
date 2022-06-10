<?php
class ajax_actas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
    }

    public function cod_acta()
    {
        $this->otro('actas');
        $request = $this->other->codigo();
        return $request;
    }

    // public function mdlProveedor()
    // {
    //     $request = $this->views->getView('App/Actas', "modalProveedor");
    //     echo $request;
    // }
}
