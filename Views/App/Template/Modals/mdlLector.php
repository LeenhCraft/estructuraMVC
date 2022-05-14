<?php
if ($data['permisos']['perm_u'] == 1) {
?>
<div class="modal fade" id="modalLector" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" class="modal-content" id="formLector">

            <div class="modal-header">
                <h5 class="modal-title">Incripción Lector</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12 col-md-6"><!--era col-8-->
           
                        <div class="row mb-md-2">
                             <label for="txtfecha"class="col-form-label w-auto">Fecha</label>
                                 <div class="col-md-6">
                                    <input name="txtfecha" class="form-control" type="date" value="2022-04-20">
                                 </div>               
                         </div>
                        <div class="row mb-md-2">
                             <label class="form-label" for="">DNI</label>
                                <div class="input-group mb-3">
                                    <input id="item" name="item" type="hidden">
                                    <input id="txtsearch" name="txtsearch" type="text" class="form-control" placeholder="000000000" aria-label="000000000" aria-describedby="button-addon2" onkeyup="val_press(this)">
                                        <div class="input-group-append">
                                          <button id="button-addon2" class="btn btn-outline-secondary" type="button" onclick="buscarDni(this, event)"><i class='bx bx-search-alt-2'></i></button>
                                         </div>
                                </div>
                        </div>
                    
                        <div class="row mb-md-2">
                            <label for="txtnombre">Nombre:</label>
                            <input id="txtnombre" name="txtnombre" type="text" class="form-control">
                        </div>
                
            
                  <div class="row">
                    <div class="col-6 ">
                        <label class="form-label" for="txtcel">Celular: </label>
                        <input id="txtcel" name="txtcel" type="number" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="">Estado</label>
                            <select name="txtestado" id="txtestado" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                    </div>
                   </div>
                    <div class="row mb-md-2">
                        <label for="txtdir">Direccion: </label>
                        <input id="txtdir" name="txtdir" type="text" class="form-control">
                    </div>
                
                   </div>

                
                    <div class="col-12 col-md-6 text-center"><!--era col-4-->
                   <!-- <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x270" alt="Cargando.." width="180">-->
                        <div class="col-sm-10">
                        <!-- <label class="form-label" for="">Añadir imagen:</label>
                             <div class="input-group mb-3" >
                                <input name="archivo" id="archivo" type="file"/>
                                 <button type="submit" name="subir" class="btn-outline-primary">
                                    <span class="tf-icons bx bx-plus-circle me-2"></span>Subir imagen
                                 </button>-->
                              <!--<input name="archivo" id="archivo" type="file"/>
                              <input type="submit" name="subir" value="Subir imagen"/>-->
                           
                             
				<div method="post" class="card" style="width: 15rem;">
					<!--<img class="card-img-top" src="img/avatars/default-avatar.png">-->
                    <img class="card-img-top" src="<?php echo media() . 'img/avatars/default-avatar.png' ?>" >

					<div class="card-body">
						<h5 class="card-title">Sube una foto</h5>
						<p class="card-text">La imagen puede ser en formato .jpg, o .png.</p>
						<div class="form-group">
							<input type="file" class="form-control-file" name="image" id="image">
						</div>
						<input type="button" class="btn btn-primary upload" value="Subir">
				     	</div>
				        </div>
           
                        </div>
                        
                </div>
                    
            </div>
        </div>
  
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <!--<button class="btn btn-primary ft-b" id="btnActionForm" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle ft-b"></i>
                            <span id="btnText">Guardar</span>
                        </button>-->
                    </div>
                
            </div>

        </form>
    </div>
</div>
<?php
}

