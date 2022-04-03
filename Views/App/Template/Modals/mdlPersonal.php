<div class="modal fade " id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" name="form" class="form-horizontal">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-5" id="divBsc">
                            <label for="">DNI: </label>
                            <div class="input-group mb-3">
                                <input id="item" name="item" type="hidden">
                                <input id="txtsearch" name="txtsearch" type="text" class="form-control" placeholder="000000000" aria-label="000000000" aria-describedby="btn">
                                <div class="input-group-append">
                                    <button id="btn" class="btn btn-outline-secondary" type="button" onclick="buscarDni(this, event)"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="txtnombre">Nombre:</label>
                            <input id="txtnombre" name="txtnombre" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="txtcel" class="text-capitalize">celular:</label>
                            <input id="txtcel" name="txtcel" type="number" class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="" class="text-capitalize">Estado:</label>
                            <select name="txtestado" id="txtestado" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="txtdir">Direccion: </label>
                            <input id="txtdir" name="txtdir" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="tile-footer mt-4">
                        <button class="btn btn-primary ft-b" id="btnActionForm" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>
                            <span id="btnText">Guardar</span>
                        </button>
                        <button class="btn btn-danger ft-b text-capitalize" type="button" data-dismiss="modal">
                            <i class="fa fa-lg fa-times-circle">
                            </i>
                            <span class="text-capitalize">cerrar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>