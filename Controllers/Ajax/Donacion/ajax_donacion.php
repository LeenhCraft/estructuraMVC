<?php
class ajax_donacion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
    }

    public function paso1()
    {
        ob_start();
        $this->views->getView('App/Donacion', "select_libro");
        $html = ob_get_clean();
        return $html;
    }
    public function paso2()
    {
        ob_start();
        $this->views->getView('App/Donacion', "new_libro");
        $html = ob_get_clean();
        return $html;
    }

    public function cod_dona()
    {
        $this->otro('donacion');
        $request = $this->other->codigo();
        return $request;
    }
}
