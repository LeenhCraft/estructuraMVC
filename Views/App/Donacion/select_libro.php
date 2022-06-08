<form onsubmit="return fn_submit_form(this)">
    <div class="col-12 row p-0 m-0 my-3 py-2">
        <input type="hidden" id="idprove" name="idprove">
        <input type="hidden" id="cod_ficha" name="cod_ficha">
        <div class="col-md-1 my-auto text-end">
            <label>Buscar</label>
        </div>
        <div class="col-lg-8">
            <select id="libros" class="form-control js-example-basic-single" placeholder="Titulo del libro">
            </select>
        </div>
        <div class="col-lg-1">
            <input type="number" id="detll3" class="form-control text-center" value="1">
        </div>
        <div class="col-lg-2">
            <button type="button" onclick="agregarDetalle()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
        </div>
    </div>
    
</form>
<script>
    $("#libros").select2({
        theme: "bootstrap4",
        width: $(this).data("width") ?
            $(this).data("width") : $(this).hasClass("w-100") ?
            "100%" : "style",
        // placeholder: "Titulo del libro",
        placeholder: $("#libros").attr('placeholder'),
        allowClear: Boolean($(this).data("allow-clear")),
        closeOnSelect: !$(this).attr("multiple"),
    });
    lstlibros();
</script>