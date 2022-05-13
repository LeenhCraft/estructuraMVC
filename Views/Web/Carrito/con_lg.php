<div class="row justify-content-center">
    <div class="col-lg-5 col-xl-4">
        <div class="s_product_text text-center">
            <h3>HOLA!!</h3>
            <h2>{{nombre}}</h2>
            <input type="hidden" id="item" name="item" value="{{val}}">
            <p>
                Falta poco para que termines tu reserva.
            </p>
            <div class="card_area d-flex justify-content-center align-items-center mb-3">
                <button type="submit" class="btn_3">Reservar</button>
            </div>
            <div class="d-flexx justify-content-center align-items-center d-none">
                <button type="button" class="btn btn-outline-secondary" onclick="cancelar(this,'{{val}}')">No quiero reservar</button>
            </div>
        </div>
    </div>
    <script>
        function reservar(e) {
            Swal.fire({
                icon:"info",
                title: 'Atención!!',
                text: 'Su reserva tiene un plazo de 24 horas para ser recogidas en nuestras oficinas, posterior a esto su reserva automaticamente cambiara a cancelada',
                input: 'checkbox',
                inputPlaceholder: 'Entiendo, deseo continuar',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                inputValidator: (result) => {
                    return !result && 'Usted debe aceptar las condiciones de reserva'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $(e).serialize();
                    let ajaxUrl = base_url + "carrito/reservar";
                    $.post(ajaxUrl, form, function(data, textStatus, jqXHR) {
                        let objData = JSON.parse(data);
                        if (textStatus == "success") {
                            Swal.fire(objData.title, objData.text, objData.icon);
                            if (objData.status) {
                                $(".cart_area").addClass('confirmation_part ').html(objData.data);
                            }
                        } else {
                            alert('Ocurrio un error');
                        }
                    });
                }
            })
            return false;
        }
    </script>
</div>