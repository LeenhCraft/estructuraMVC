<div class="modal fade" id="modalsubmenus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo submenus</h5>
            </div>
            <div class="modal-body">
                <form id="formsubmenus" name="formsubmenus" class="form-horizontal">
                    <input type="hidden" id="item" name="item">
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12 div_id d-none">
                            <label for="txtIdsubmenu">Id</label>
                            <input type="text" class="form-control" id="txtIdsubmenu" name="txtIdsubmenu" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_nombre">Sub Menu</label>
                            <input type="text" class="form-control" id="txtSub_nombre" name="txtSub_nombre">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_icono">Icono</label>
                            <input type="text" class="form-control" id="txtSub_icono" name="txtSub_icono">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_url">Url</label>
                            <input type="text" class="form-control" id="txtSub_url" name="txtSub_url">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_controlador">Controlador</label>
                            <input type="text" class="form-control" id="txtSub_controlador" name="txtSub_controlador">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_orden">Orden</label>
                            <input type="number" class="form-control" id="txtSub_orden" name="txtSub_orden">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="txtSub_visible">Visible</label>
                            <select class="form-control" id="txtSub_visible" name="txtSub_visible">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12 div_id">
                            <label for="txtSub_fecha">F. Creación</label>
                            <input type="text" class="form-control" id="txtSub_fecha" disabled>
                        </div>
                    </div>

                    <div class="tile-footer mt-4">
                        <button class="btn btn-primary ft-b" id="btnActionForm" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle ft-b"></i>
                            <span id="btnText">Guardar</span>
                        </button>
                        <button class="btn btn-danger ft-b text-capitalize ml-2" type="button" data-dismiss="modal">
                            <i class="fa fa-lg fa-times-circle ft-b"></i>
                            <span class="text-capitalize">cerrar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Views -->
<div class="modal fade" id="mdView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Submenus</h5>
            </div>
            <div class="modal-body">

                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td>Idsubmenu: </td>
                            <td id="idsubmenu"></td>
                        </tr>
                        <tr>
                            <td>Idmenu: </td>
                            <td id="idmenu"></td>
                        </tr>
                        <tr>
                            <td>Sub_nombre: </td>
                            <td id="sub_nombre"></td>
                        </tr>
                        <tr>
                            <td>Sub_url: </td>
                            <td id="sub_url"></td>
                        </tr>
                        <tr>
                            <td>Sub_controlador: </td>
                            <td id="sub_controlador"></td>
                        </tr>
                        <tr>
                            <td>Sub_icono: </td>
                            <td id="sub_icono"></td>
                        </tr>
                        <tr>
                            <td>Sub_orden: </td>
                            <td id="sub_orden"></td>
                        </tr>
                        <tr>
                            <td>Sub_visible: </td>
                            <td id="sub_visible"></td>
                        </tr>
                        <tr>
                            <td>Sub_fecha: </td>
                            <td id="sub_fecha"></td>
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