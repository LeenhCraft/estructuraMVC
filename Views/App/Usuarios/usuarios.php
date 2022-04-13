<?php
headerApp('Template/header_dash', $data);
getModal('mdlUsuarios', $data);
?>

<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Agregar
        </button>
    </div>
    <div class="table-responsive text-nowrap mb-4">
        <table id="tb" class="table table-hover" width="100%">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php footerApp('Template/footer_dash', $data) ?>