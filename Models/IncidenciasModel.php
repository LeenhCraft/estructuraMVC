<?php
class IncidenciasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT idpersona as id, per_dni as dni, per_nombre as nombre,per_estado as estado, per_fecha as fecha FROM bib_personal ORDER BY idpersona DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function buscar($dni)
    {
        $sql = "SELECT * FROM web_usuarios WHERE usu_dni = '$dni'";
        $request = $this->select($sql);
        return $request;
    }

    public function lstreservas($dni)
    {
        $sql = "SELECT a.idprestamo as id,a.pres_cod as cod, 
        DATE_FORMAT(a.pres_fprestamo,'%e/%m/%Y') AS prestamo,
        DATE_FORMAT(a.pres_fdevolucion,'%e/%m/%Y') AS dprestamo,
        a.pres_estado as estado 
        FROM bib_prestamos a 
        INNER JOIN web_usuarios b 
        ON a.idwebusuario =b.idwebusuario 
        WHERE b.usu_dni = '$dni'";

        $request = $this->select_all($sql);
        return $request;
    }

    public function lst_detpres($id)
    {
        $sql = "SELECT * FROM bib_det_prestamos a INNER JOIN bib_articulos b ON b.idarticulo=a.idarticulo WHERE a.idprestamo = '$id'";
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

    public function lstlibros()
    {
        $sql = "SELECT * FROM bib_articulos WHERE idtipoarticulo = 1 AND art_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertar($dni, $nombre, $cel, $dir, $estado = 1)
    {
        $return = [];
        $sql = "SELECT * FROM bib_personal WHERE per_dni = '{$dni}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO bib_personal(per_dni,per_nombre,per_celular,per_direc,per_estado) VALUES(?,?,?,?,?)";
            $arrData = array($dni, $nombre, $cel, $dir, $estado);
            $response = $this->insert($sql, $arrData);
            if ($response > 0) {
                $return['status'] = true;
                $return['data'] = '';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al intentar registrar el personal.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'El DNI que esta tratando de ingresar ya esta registrado.';
        }
        return $return;
    }

    public function actualizar($id, $dni, $nombre, $cel, $dir, $estado)
    {
        $sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE bib_personal SET per_dni=?,per_nombre=?, per_celular=?,per_direc=?, per_estado=? WHERE idpersona = $id";
            $arrData = array($dni, $nombre, $cel, $dir, $estado);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function motivos()
    {
        $sql = "SELECT idmotivos as id, mot_nombre as nombre FROM bib_motivos_inci";
        $request = $this->select_all($sql);
        return $request;
    }



    public function eliminar(int $id)
    {
        $sql = "SELECT * FROM bib_personal WHERE idpersona = $id";
        $request = $this->select($sql);
        if (!empty($request)) {
            $sql = "DELETE FROM bib_personal WHERE idpersona = $id";
            $arrData = array(0);
            $request = $this->delete($sql, $arrData);
            if ($request) {
                $return['status'] = true;
                $return['data'] = 'El registro fue eliminado!';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de eliminar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'No se encontraron registros.';
        }
        return $return;
    }

    public function inert_inci($usu_id, $idprestamo, $estado, $idarticulo, $idmotivo, $detalle)
    {
        $sql = "SELECT * FROM bib_incidencias WHERE usu_id = '$usu_id' AND idprestamo ='$idprestamo'";
        $request = $this->select($sql);
        $idincidencia = '';
        if (empty($request)) {
            $sql = "INSERT INTO bib_incidencias (usu_id,idprestamo,inc_estado)VALUES(?,?,?)";
            $arrData = array($usu_id, $idprestamo, $estado);
            $request = $this->insert($sql, $arrData);
            $idincidencia = $request;
        } else {
            $idincidencia = $request['idincidencia'];
        }
        // if ($request > 0) {

        $sql = "SELECT * FROM bib_det_incidencia WHERE idincidencia = '$idincidencia'AND idarticulo = $idarticulo";
        $rp = $this->select($sql);
        if (empty($rp)) {
            $sql = "INSERT INTO bib_det_incidencia(idincidencia,idarticulo,idmotivos,det_descri)VALUES(?,?,?,?)";
            $arrData = array($idincidencia, $idarticulo, $idmotivo, $detalle);
            $request = $this->insert($sql, $arrData);
            if ($request > 0) {
                $return['status'] = true;
                $return['text'] = '';
            } else {
                $return['status'] = false;
                $return['text'] = 'Ocurrio un error al intentar registrar el detalle de la incidencia.';
            }
        } else {
            $return['status'] = false;
            $return['text'] = 'Ya hay una incidencia registrada para este articulo.';
        }


        // } else {
        //     $return['status'] = false;
        //     $return['text'] = 'Ocurrio un error al intentar registrar la incidencia.';
        // }
        return $return;
    }
}
