<?php
class OrdencompraModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buscar($dni)
    {
        $sql = "SELECT * FROM web_usuarios WHERE usu_dni = '$dni'";
        $request = $this->select($sql);
        return $request;
    }

    public function lst_detpres($id)
    {
        $sql = "SELECT * FROM bib_det_prestamos WHERE idprestamo = '$id'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function lstincidentes($dni)
    {
        $sql = "SELECT
                    a.idprestamo,
                    b.pres_cod AS cod_prestamo,
                    e.art_nombre AS libro,
                    DATE_FORMAT(a.inc_fecha, '%e/%m/%Y') AS fecha,
                    f.mot_nombre as motivo
                FROM
                    bib_incidencias a
                INNER JOIN bib_prestamos b ON
                    b.idprestamo = a.idprestamo
                INNER JOIN web_usuarios c ON
                    c.idwebusuario = b.idwebusuario
                INNER JOIN bib_det_incidencia d ON
                    d.idincidencia = a.idincidencia
                INNER JOIN bib_articulos e ON
                    e.idarticulo = d.idarticulo
                INNER JOIN bib_motivos_inci f ON
                    f.idmotivos = d.idmotivos
                WHERE
                    c.usu_dni = '$dni'";
        $request = $this->select_all($sql);
        return $request;
    }
 

    public function registrar($idlector, $libros, $cant, $codPrestamo, $idusuario, $fpres, $fdev, $estado)
    {
        $sql = "INSERT INTO bib_prestamos(pres_cod,usu_id,idwebusuario,pres_fprestamo,pres_fdevolucion,pres_estado) VALUES(?,?,?,?,?,?)";
        $arrData = array($codPrestamo, $idusuario, $idlector, $fpres, $fdev, $estado);
        $response = $this->insert($sql, $arrData);
        if ($response > 0) {
            for ($i = 0; $i < count($libros); $i++) {
                $sql = "INSERT INTO bib_det_prestamos(idprestamo,idarticulo,det_cant) VALUES(?,?,?)";
                $arrData = array($response, $libros[$i], $cant[$i]);
                $response = $this->insert($sql, $arrData);
            }
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'Ocurrio un error al intentar registrar el personal.';
        }
        return $return;
    }
}
