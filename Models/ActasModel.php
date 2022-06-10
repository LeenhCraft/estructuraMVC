<?php
class ActasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function codigo()
    {
        do {
            $cod = generar_numeros(5);
            $sql = "SELECT * FROM bib_actas WHERE act_codigo = '$cod'";
            $existe = $this->select($sql);
        } while (!empty($existe));
        return $cod;
    }

    public function buscar($ndoc)
    {
        // $sql = "SELECT a.iddonacion,a.don_cod,c.tpro_nombre,d.tpd_nombre,b.pro_nombrecompleto,b.pro_razonsocial,a.don_fecha FROM bib_donaciones a  
        // INNER JOIN bib_pro_don b ON b.idprodon=a.idprodon 
        // INNER JOIN bib_tppersona c ON c.idtppersona=b.idtppersona
        // INNER JOIN bib_tipodocs d on d.idtipodoc=b.idtipodoc
        // WHERE b.pro_dni = '$ndoc' OR b.pro_ruc = '$ndoc' AND a.don_acta = 0";
        $sql = "SELECT * FROM bib_pro_don a 
        INNER JOIN bib_tppersona b ON b.idtppersona=a.idtppersona
        WHERE a.pro_ruc = '$ndoc' OR a.pro_dni = '$ndoc'";
        $request = $this->select($sql);
        return $request;
    }

    public function bsc_fichas($ndoc)
    {
        $sql = "SELECT a.iddonacion,a.don_cod,c.tpro_nombre,d.tpd_nombre,b.pro_nombrecompleto,b.pro_razonsocial,a.don_fecha FROM bib_donaciones a  
        INNER JOIN bib_pro_don b ON b.idprodon=a.idprodon 
        INNER JOIN bib_tppersona c ON c.idtppersona=b.idtppersona
        INNER JOIN bib_tipodocs d on d.idtipodoc=b.idtipodoc
        WHERE (b.pro_dni = '$ndoc' OR b.pro_ruc = '$ndoc') AND a.don_acta = 0";

        $request = $this->select_all($sql);
        return $request;
    }

    public function cont_libros($idDonacion)
    {
        $sql = "SELECT  SUM(detd_cantidad) AS cant FROM bib_detalle_donacion WHERE iddonacion='$idDonacion'";
        $request = $this->select($sql);
        return $request;
    }

    public function det_donacion($idDonacion)
    {
        $sql = "SELECT b.don_cod,c.art_cod,c.art_isbn,c.art_nombre,a.detd_cantidad FROM bib_detalle_donacion a 
        INNER JOIN bib_donaciones b ON b.iddonacion=a.iddonacion
        INNER JOIN bib_articulos c ON c.idarticulo=a.idarticulo
        WHERE a.iddonacion = '$idDonacion'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function registrar($codFicha, $usu_id, $idDona, $estado)
    {
        $sql = "SELECT * FROM bib_donaciones WHERE don_acta !=0 AND iddonacion  = '$idDona'";
        $request = $this->select($sql);
        if (empty($request)) {
            $sql = "INSERT INTO bib_actas(act_codigo,usu_id,iddonacion,act_estado) VALUES(?,?,?,?)";
            $arrData = array($codFicha, $usu_id, $idDona, $estado);
            $request = $this->insert($sql, $arrData);
            if ($request > 0) {
                $sql = "UPDATE bib_donaciones SET don_acta = ? WHERE iddonacion = ?";
                $arrData = array(1, $idDona);
                $request = $this->update($sql, $arrData);
            }
            $return['status'] = true;
            $return['text'] = '';
        } else {
            $return['status']   = false;
            $return['text']  = "La donación ya tiene un acta registrada";
        }

        return $return;
    }
}
