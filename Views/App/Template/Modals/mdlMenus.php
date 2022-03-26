<div class="modal fade" id="modalmenus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo menus</h5>
            </div>
            <div class="modal-body">
                <form id="formmenus" name="formmenus" class="form-horizontal">
                    <input type="hidden" id="idIdmenu" name="idIdmenu" value="">
                    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtIdmenu">Idmenu</label>
                    <input type="text" class="form-control" id="txtIdmenu" name="txtIdmenu">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_nombre">Men_nombre</label>
                    <input type="text" class="form-control" id="txtMen_nombre" name="txtMen_nombre">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_icono">Men_icono</label>
                    <input type="text" class="form-control" id="txtMen_icono" name="txtMen_icono">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_url_si">Men_url_si</label>
                    <input type="text" class="form-control" id="txtMen_url_si" name="txtMen_url_si">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_url">Men_url</label>
                    <input type="text" class="form-control" id="txtMen_url" name="txtMen_url">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_controlador">Men_controlador</label>
                    <input type="text" class="form-control" id="txtMen_controlador" name="txtMen_controlador">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_orden">Men_orden</label>
                    <input type="text" class="form-control" id="txtMen_orden" name="txtMen_orden">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_visible">Men_visible</label>
                    <input type="text" class="form-control" id="txtMen_visible" name="txtMen_visible">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtMen_fecha">Men_fecha</label>
                    <input type="text" class="form-control" id="txtMen_fecha" name="txtMen_fecha">
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