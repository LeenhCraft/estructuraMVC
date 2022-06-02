<?php
class DonacionModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function codigo()
    {
        do {
            $cod = generar_numeros(5);
            $sql = "SELECT * FROM bib_donaciones WHERE don_cod = '$cod'";
            $existe = $this->select($sql);
        } while (!empty($existe));
        return $cod;
    }

    public function persona($doc)
    {
        $sql = "SELECT * FROM bib_pro_don WHERE pro_estado = 1 AND pro_dni = '$doc' OR pro_ruc = '$doc'";
        $request = $this->select($sql);
        return $request;
    }

    public function tipos_personas()
    {
        $sql = "SELECT * FROM bib_tppersona WHERE tpro_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function tipo_doc()
    {
        $sql = "SELECT * FROM bib_tipodocs WHERE tpd_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function registrar($idproveedor, $idusuario, $libros, $cant, $codFicha, $estado)
    {
        $sql = "INSERT INTO bib_donaciones(don_cod,idprodon,usu_id,don_estado) VALUES(?,?,?,?)";
        $arrData = array($codFicha, $idproveedor, $idusuario, $estado);
        $response = $this->insert($sql, $arrData);
        if ($response > 0) {
            for ($i = 0; $i < count($libros); $i++) {
                $sql = "INSERT INTO bib_detalle_donacion(iddonacion,idarticulo,detd_cantidad) VALUES(?,?,?)";
                $arrData = array($response, $libros[$i], $cant[$i]);
                $response = $this->insert($sql, $arrData);
            }
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'Ocurrio un error al intentar registrar la donación, por favor vuelva a intentarlo.';
        }
        return $return;
    }

    public function lstlibros()
    {
        $sql = "SELECT * FROM bib_articulos WHERE idtipoarticulo = 1 AND art_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }
}
