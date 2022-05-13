<?php
class CarritoModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function articulos($idvisita)
    {
        $sql = "SELECT * FROM web_carritos a INNER JOIN	bib_articulos b ON b.idarticulo=a.idarticulo WHERE a.idvisita = $idvisita AND idreserva=0 AND a.car_anulado = 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function hay_pendientes()
    {
        $idvisita = $_SESSION['vi'];
        $sql = "SELECT * FROM sis_visitas WHERE vis_cod = $idvisita AND idwebusuario != 0";
        $request = $this->select($sql);
        $idwebusuario = 0;
        if (!empty($request)) {
            $idwebusuario = $request['idwebusuario'];
            $sql = "SELECT * FROM web_carritos a INNER JOIN	bib_articulos b ON b.idarticulo=a.idarticulo WHERE a.idvisita = $idvisita AND a.idwebusuario = $idwebusuario AND a.idreserva=0 AND a.car_anulado = 0";
            $request = $this->select_all($sql);
        }
        return [$request, $idwebusuario];
    }

    public function eliminar($id)
    {
        $request = [];
        $sql = "SELECT * FROM web_carritos WHERE idcarrito = $id";
        $request = $this->select($sql);
        if (!empty($request)) {
            $sql = "UPDATE web_carritos SET car_anulado = 1 WHERE idcarrito = $id";
            $request = $this->delete($sql);
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

    public function existe($id)
    {
        $sql = "SELECT * FROM web_carritos WHERE idcarrito = $id AND car_anulado = 0";
        $request = $this->select($sql);
        return $request;
    }

    public function stock($id, $cant)
    {
        $sql = "SELECT * FROM bib_articulos a INNER JOIN web_carritos b ON b.idarticulo = a.idarticulo WHERE b.idcarrito = $id AND a.art_estado = 1 AND a.art_stock >= $cant";
        $request = $this->select($sql);
        return $request;
    }

    public function upd_cant($id, $cant)
    {
        $sql = "UPDATE web_carritos SET car_cantidad = ? WHERE idcarrito = $id AND car_anulado = 0";
        $arrData = array($cant);
        $request = $this->update($sql, $arrData);
        if ($request) {
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'Ocurrio un error al tratar de actualizar el registro.';
        }

        return $return;
    }

    public function header_reserva($idwebusuario, $usu_id, $estado)
    {
        do {
            $num_res = generar_numeros(5);
            $sql = "SELECT * FROM bib_reservas WHERE res_num = '$num_res'";
            $existe = $this->select($sql);
        } while (!empty($existe));
        $sql = "INSERT INTO bib_reservas (res_num, idwebusuario , usu_id, res_estado) VALUES (?, ?, ?, ?)";
        $arrData = array($num_res, $idwebusuario, $usu_id, $estado);
        $request = $this->insert($sql, $arrData);
        $idvisita = $_SESSION['vi'];
        if ($request > 0) {
            $sql = "UPDATE web_carritos SET idreserva=? WHERE idvisita=?  AND idwebusuario=? AND car_anulado=0";
            $arrData = array($num_res, $idvisita, $idwebusuario);
            $request = $this->update($sql, $arrData);
            $return['status'] = true;
            $return['data'] = $num_res;
        } else {
            $return['status'] = false;
            $return['data'] = 0;
        }
        return $return;
    }
}
