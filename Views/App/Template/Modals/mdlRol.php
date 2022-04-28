<?php
if ($data['permisos']['perm_u'] == 1) {
?>
    <div class="modal fade" id="modalRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" class="modal-content" id="formRol">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo rol</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idIdrol" name="idIdrol" value="">

                    <div class="mb-3 col-md-3 col-12 d-none _hiden">
                        <label class="form-label txtIdmenu text-caputalize" for="txtIdrol">Idrol</label>
                        <input type="text" class="form-control" id="txtIdrol" name="txtIdrol" disabled>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="txtRol_cod">Cod.</label>
                            <input type="text" class="form-control" id="txtRol_cod" name="txtRol_cod">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="txtRol_nombre">Nombre</label>
                            <input type="text" class="form-control" id="txtRol_nombre" name="txtRol_nombre">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="fom-label" for="txtRol_descripcion">Descripción</label>
                        <textarea class="form-control" name="txtRol_descripcion" id="txtRol_descripcion" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="txtRol_estado">Estado</label>
                            <select class="form-control" id="txtRol_estado" name="txtRol_estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 d-none _hiden">
                            <label class="form-label" for="txtRol_fecha">Fecha</label>
                            <input type="text" class="form-control" id="txtRol_fecha" name="txtRol_fecha" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
<?php
}
if ($data['permisos']['perm_r'] == 1) {
?>
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
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>