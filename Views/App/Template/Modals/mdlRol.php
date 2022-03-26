<div class="modal fade" id="modalRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
            </div>
            <div class="modal-body">
                <form id="formRol" name="formRol" class="form-horizontal">
                    <input type="hidden" id="idIdrol" name="idIdrol" value="">
                    
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtIdrol">Idrol</label>
                    <input type="text" class="form-control" id="txtIdrol" name="txtIdrol">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtRol_nombre">Rol_nombre</label>
                    <input type="text" class="form-control" id="txtRol_nombre" name="txtRol_nombre">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtRol_cod">Rol_cod</label>
                    <input type="text" class="form-control" id="txtRol_cod" name="txtRol_cod">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtRol_descripcion">Rol_descripcion</label>
                    <input type="text" class="form-control" id="txtRol_descripcion" name="txtRol_descripcion">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtRol_estado">Rol_estado</label>
                    <input type="text" class="form-control" id="txtRol_estado" name="txtRol_estado">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="txtRol_fecha">Rol_fecha</label>
                    <input type="text" class="form-control" id="txtRol_fecha" name="txtRol_fecha">
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
                <h5 class="modal-title" id="titleModal">Datos del Rol</h5>
            </div>
            <div class="modal-body">

                <table class="table table-bordered">
                    <tbody>
                        
            <tr>
                <td>Idrol: </td>
                <td id="idrol"></td>
            </tr>
            <tr>
                <td>Rol_nombre: </td>
                <td id="rol_nombre"></td>
            </tr>
            <tr>
                <td>Rol_cod: </td>
                <td id="rol_cod"></td>
            </tr>
            <tr>
                <td>Rol_descripcion: </td>
                <td id="rol_descripcion"></td>
            </tr>
            <tr>
                <td>Rol_estado: </td>
                <td id="rol_estado"></td>
            </tr>
            <tr>
                <td>Rol_fecha: </td>
                <td id="rol_fecha"></td>
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