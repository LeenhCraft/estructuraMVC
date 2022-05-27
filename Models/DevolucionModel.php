<?php
class DevolucionModel extends Mysql
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
        $sql = "SELECT a.idprestamo as id, 
        a.pres_cod AS cod_prestamo,
        DATE_FORMAT(a.pres_fprestamo,'%e/%m/%Y') AS prestamo,
        DATE_FORMAT(a.pres_fdevolucion,'%e/%m/%Y') AS dprestamo,
        a.pres_estado as estado 

        FROM bib_prestamos a 
        INNER JOIN web_usuarios b 
        ON a.idwebusuario =b.idwebusuario
        INNER JOIN bib_det_prestamos c 
        ON c.idprestamo = a.idprestamo 


        WHERE b.usu_dni = '$dni'";

        $request = $this->select_all($sql);
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

    /*public function lstlibros()
    {
        $sql = "SELECT * FROM bib_articulos WHERE idtipoarticulo = 1 AND art_estado = 1";
        $request = $this->select_all($sql);
        return $request;
    }*/

    /*public function insertar($dni, $nombre, $cel, $dir, $estado = 1)
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
    }*/

    public function actualizar($dev)
    {
        $request = [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE bib_prestamos SET pres_estado=? WHERE idprestamo =?";
            $arrData = array(1,$dev);
            $request = $this->update($sql, $arrData);
            $return['status'] = true;
            $return['data'] = 'El estado que esta ingresando ya esta registrado.';
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $return;
    }

    public function lstdetalledevolucion($dni)
    {
        $sql = "SELECT
                    a.idprestamo,
                    a.pres_cod AS cod_prestamo,
                    d.art_isbn AS cod_isbn,
                    d.art_nombre AS titulo,
                    d.art_nombre AS editorial,
                    d.art_nombre AS autor,
                    d.art_nombre AS edicion,
                    e.tp_nombre AS formato
                   
                    
                FROM
                    bib_prestamos a
                INNER JOIN bib_det_prestamos b ON
                    b.idprestamo = a.idprestamo
                INNER JOIN web_usuarios c ON
                    c.idwebusuario = a.idwebusuario
                INNER JOIN bib_articulos d ON
                    d.idarticulo = b.idarticulo
                INNER JOIN bib_tipoarticulos e ON
                    e.idtipoarticulo = d.idtipoarticulo
                WHERE
                    c.usu_dni = '$dni'";
        $request = $this->select_all($sql);
        return $request;
    }
    /*public function persona(int $id)
    {
        $sql = "SELECT idpersona as nmr,per_dni as dni, per_nombre as nombre, per_celular as cel, per_direc as dir, per_estado as estado FROM bib_personal WHERE idpersona = $id";
        $request = $this->select($sql);
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
    }*/
}