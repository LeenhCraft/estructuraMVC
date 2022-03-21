<?php
class serverEmail extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function leerConfig()
    {
        $sql = "SELECT * FROM sis_server_email WHERE em_default = 1 AND em_estado = 1";
        $request = $this->select($sql);
        return $request;
        // // 
        // $row = [];
        // try {
        //     $stm = $this->cone->prepare("SELECT * FROM sis_server_email WHERE conf_estado =1");
        //     $stm->execute();
        //     if ($stm->rowCount() > 0) {
        //         $row = $stm->fetch(PDO::FETCH_OBJ);
        //     }
        // } catch (PDOException $e) {
        //     echo $e->getMessage();
        //     exit;
        // }
        // return $row;
    }
}
