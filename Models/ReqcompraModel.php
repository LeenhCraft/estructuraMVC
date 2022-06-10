<?php
class ReqcompraModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT
                    idarticulo AS id,
                    art_isbn as isbn,
                    art_nombre AS titulo,
                    art_cod AS autor,
                    art_stock AS stock
                   
                FROM bib_articulos WHERE art_stock<5
                ORDER BY art_stock ASC";
        $request = $this->select_all($sql);
        return $request;
    }



    public function lstlibros()
    {
        $sql = "SELECT * FROM bib_articulos WHERE idtipoarticulo = 1 AND art_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }

  
    public function registrar( $libros, $cant, $codReq, $idusuario,$estado)
    {
        $sql = "INSERT INTO bib_requerimientos(req_codigo,usu_id,req_estado) VALUES(?,?,?)";
        $arrData = array($codReq, $idusuario,$estado);
        $idreq = $this->insert($sql, $arrData);
        if ($idreq > 0) {
            for ($i = 0; $i < count($libros); $i++) {
                $sql = "INSERT INTO bib_detrequerimiento(idrequerimiento,idarticulo,det_cantidad) VALUES(?,?,?)";
                $arrData = array($idreq, $libros[$i], $cant[$i]);
                $response = $this->insert($sql, $arrData);
            }
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'Ocurrio un error al intentar registrar el requerimiento.';
        }
        return $return;
    }
    
    public function codigo()
    {

        //esto genera el codigo, lo consulta si no existe, y si no existe nos regresa el codigo, si existe genera uno nuevo y hace nuevamente la consulta
        do {
            $cod = generar_numeros(5);
            $sql = "SELECT * FROM bib_donaciones WHERE don_cod = '$cod'";
            $existe = $this->select($sql);
        } while (!empty($existe));
        return $cod;
    }
    

}
