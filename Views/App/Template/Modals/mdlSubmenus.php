<div class="modal fade" id="modalsubmenus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo submenus</h5>
            </div>
            <div class="modal-body">
                <form id="formsubmenus" name="formsubmenus" class="form-horizontal">
                    <input type="hidden" id="idIdsubmenu" name="idIdsubmenu" value="">
                    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtIdsubmenu">Idsubmenu</label>
                    <input type="text" class="form-control" id="txtIdsubmenu" name="txtIdsubmenu">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtIdmenu">Idmenu</label>
                    <input type="text" class="form-control" id="txtIdmenu" name="txtIdmenu">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_nombre">Sub_nombre</label>
                    <input type="text" class="form-control" id="txtSub_nombre" name="txtSub_nombre">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_url">Sub_url</label>
                    <input type="text" class="form-control" id="txtSub_url" name="txtSub_url">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_controlador">Sub_controlador</label>
                    <input type="text" class="form-control" id="txtSub_controlador" name="txtSub_controlador">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_icono">Sub_icono</label>
                    <input type="text" class="form-control" id="txtSub_icono" name="txtSub_icono">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_orden">Sub_orden</label>
                    <input type="text" class="form-control" id="txtSub_orden" name="txtSub_orden">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_visible">Sub_visible</label>
                    <input type="text" class="form-control" id="txtSub_visible" name="txtSub_visible">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtSub_fecha">Sub_fecha</label>
                    <input type="text" class="form-control" id="txtSub_fecha" name="txtSub_fecha">
                </div>
            </div>
            
                    <div class="tile-footer mt-4">
                        <button class="btn btn-primary ft-b" id="btnActionForm" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>
                            <span id="btnText">Guardar</span>
                        </button>
                        <button class="btn btn-danger ft-b text-capitalize ml-2" type="button" data-dismiss="modal">
                            <i class="fa fa-lg fa-times-circle"></i>
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