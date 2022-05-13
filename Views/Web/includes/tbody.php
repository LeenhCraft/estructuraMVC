<?php
function articulos($data)
{
    $html = '';
    $total = 0;
    if (!empty($data)) {

        foreach ($data as $row) {
            $html .= '
        <tr>
            <td>
                <div class="media">
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <img width="80" src="https://web.cosmobook.pe/app/img/mini/20220103_48iV.jpg" alt="Cargando..." />
                    </div>
                    <div class="media-body">
                        <p class="h4-md h5 text-break mb-md-2">' . $row['art_nombre'] . '</p>
                        <p class="d-none d-md-inline">' . $row['art_descri'] . '</p>
                    </div>
                </div>
            </td>
            <td class="d-none">
                <div class="product_count">
                    <input class="input-number p-0 text-center" type="text" value="' . $row['car_cantidad'] . '" min="0" max="50"  onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" onblur="upd_can(this, ' . $row['idcarrito'] . ')">
                </div>
            </td>
            <td class="text-center p-0">
                <span title="Eliminar item?" onclick="eliminar(this,' . $row['idcarrito'] . ')" style="cursor:pointer" class="ti-close p-3"></span>
            </td>
        </tr>
    ';
            $total += $row['car_cantidad'];
        }
        $html .= '
    <tr>
        <td class="text-right font-weight-bold">Total de articulos</td>
        <td>
            <div class="product_count text-center" style="width: 100px;">
                <span class="font-weight-bold">' . $total . '</span>
            </div>
        </td>
        <td></td>
    </tr>
    ';
    } else {
        $html = '
        <tr>
            <td colspan="3" class="text-center text-primary text-capitalize h4">
                sin articulos
            </td>
        </tr>
        ';
    }

    return [$html, $total];
}

function articulos2($data)
{
    $html = '';
    $total = 0;
    if (!empty($data)) {

        foreach ($data as $row) {
            $html .= '
        <tr>
            <td>
                <div class="media">
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <img width="80" src="https://web.cosmobook.pe/app/img/mini/20220103_48iV.jpg" alt="Cargando..." />
                    </div>
                    <div class="media-body">
                        <p class="h4-md h5 text-break mb-md-2">' . $row['art_nombre'] . '</p>
                        <p class="d-none d-md-inline">' . $row['art_descri'] . '</p>
                    </div>
                </div>
            </td>
            <td class="d-none">
                <div class="product_count">
                    <input class="input-number p-0 text-center" type="text" value="' . $row['car_cantidad'] . '" min="0" max="50"  onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" onblur="upd_can(this, ' . $row['idcarrito'] . ')">
                </div>
            </td>
            <td class="text-center p-0">
            </td>
        </tr>
    ';
            $total += $row['car_cantidad'];
        }
        $html .= '
    <tr>
        <td class="text-right font-weight-bold">Total de articulos</td>
        <td>
            <div class="product_count text-center" style="width: 100px;">
                <span class="font-weight-bold">' . $total . '</span>
            </div>
        </td>
        <td></td>
    </tr>
    ';
    } else {
        $html = '
        <tr>
            <td colspan="3" class="text-center text-primary text-capitalize h4">
                sin articulos
            </td>
        </tr>
        ';
    }

    return $html;
}
