<div class="modal fade" id="modalmenus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalmenusTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="idIdmenu" name="idIdmenu" value="">
                <div class="mb-3 col-md-3 col-12">
                    <label class="form-label txtIdmenu text-caputalize" for="basic-default-fullname">id</label>
                    <input type="text" class="form-control" id="txtIdmenu" name="txtIdmenu" disabled>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="txtMen_nombre">Nombre</label>
                        <input type="text" class="form-control" id="txtMen_nombre" name="txtMen_nombre">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="txtMen_icono">Icono</label>
                        <input type="text" class="form-control" id="txtMen_icono" name="txtMen_icono">
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-4">
                        <div class="input-group border-0 d-flex align-items-center">
                            <div class="input-group-text border-0">
                                <input class="form-check-input mt-0" id="txtMen_url_si" name="txtMen_url_si" type="checkbox">
                            </div>
                            <label class="p-0 m-0 form-label" for="txtMen_url_si">Nivel 1</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 in_hidde" style="display: none;">
                        <!-- <label for="txtMen_url">Men_url</label> -->
                        <input type="text" class="form-control" id="txtMen_url" name="txtMen_url" placeholder="url del menu" disabled>
                    </div>
                    <div class="col-md-4 in_hidde" style="display: none;">
                        <!-- <label for="txtMen_controlador">Men_controlador</label> -->
                        <input type="text" class="form-control" id="txtMen_controlador" name="txtMen_controlador" placeholder="Controlador" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="txtMen_orden">Orden</label>
                        <input type="number" class="form-control" id="txtMen_orden" name="txtMen_orden">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="txtMen_visible">Visible</label>
                        <!-- <input type="text" class="form-control" id="txtMen_visible" name="txtMen_visible"> -->
                        <select class="form-control" id="txtMen_visible" name="txtMen_visible">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="row div_fecha">
                    <div class="col-12 col-md-6">
                        <label for="txtMen_fecha">F. Creación</label>
                        <input type="text" class="form-control" id="txtMen_fecha" name="txtMen_fecha" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Views -->
<div class="modal fade" id="mdView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Menus</h5>
            </div>
            <div class="modal-body">

                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td>Idmenu: </td>
                            <td id="idmenu"></td>
                        </tr>
                        <tr>
                            <td>Men_nombre: </td>
                            <td id="men_nombre"></td>
                        </tr>
                        <tr>
                            <td>Men_icono: </td>
                            <td id="men_icono"></td>
                        </tr>
                        <tr>
                            <td>Men_url_si: </td>
                            <td id="men_url_si"></td>
                        </tr>
                        <tr>
                            <td>Men_url: </td>
                            <td id="men_url"></td>
                        </tr>
                        <tr>
                            <td>Men_controlador: </td>
                            <td id="men_controlador"></td>
                        </tr>
                        <tr>
                            <td>Men_orden: </td>
                            <td id="men_orden"></td>
                        </tr>
                        <tr>
                            <td>Men_visible: </td>
                            <td id="men_visible"></td>
                        </tr>
                        <tr>
                            <td>Men_fecha: </td>
                            <td id="men_fecha"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>