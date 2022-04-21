<?php
class Me extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $request = $this->views->getView('Web/includes', "login");
        echo $request;
    }
    public function register()
    {
        $request = $this->views->getView('Web/includes', "register");
        echo $request;
    }
}
