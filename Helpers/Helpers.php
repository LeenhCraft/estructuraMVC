<?php

//Retorla la url del proyecto
function base_url()
{
    return BASE_URL;
}
function media()
{
    return BASE_URL . "Assets/";
}

function headerWeb($view, $data = "")
{
    $view_header = "Views/Web/Template/$view.php";
    require_once $view_header;
}

function footerWeb($view, $data = "")
{
    $view_footer = "Views/Web/Template/$view.php";
    require_once $view_footer;
}

function headerApp($view, $data = "")
{
    $view_header = "Views/App/$view.php";
    require_once $view_header;
}

function footerApp($view, $data = "")
{
    $view_footer = "Views/App/$view.php";
    require_once $view_footer;
}

//Muestra información formateada
function dep($data, $exit = 0)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    ($exit != 0) ? $format .= exit : '';
    return $format;
}
//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}
//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}
//Genera un token
function token($cant = 10)
{
    $r1 = bin2hex(random_bytes($cant));
    $r2 = bin2hex(random_bytes($cant));
    $r3 = bin2hex(random_bytes($cant));
    $r4 = bin2hex(random_bytes($cant));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}
//Formato para valores monetarios
function formatMoney($cantidad)
{
    $cantidad = SMONEY . number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}

// Generador de números 
function generar_numeros($digitos = 8)
{
    $num = 0;
    $num = mt_rand(pow(10, $digitos - 1), pow(10, $digitos) - 1);
    return $num;
}

//Generador de letras
function generar_letras($strength = 16)
{
    $input = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

// url pero amigable
function urls_amigables($url)
{
    // Tranformamos todo a minusculas
    $url = strtolower($url);
    //Rememplazamos caracteres especiales latinos
    $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
    $repl = array('a', 'e', 'i', 'o', 'u', 'n');
    $url = str_replace($find, $repl, $url);
    // Añadimos los guiones
    $find = array(' ', '&', '\r\n', '\n', '+');
    $url = str_replace($find, '-', $url);
    // Eliminamos y Reemplazamos demás caracteres especiales
    $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
    $repl = array('', '-', '');
    $url = preg_replace($find, $repl, $url);
    return $url;
}

// para enviar correo electronico
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($data, $template)
{
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    require_once 'Models/serverEmail.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $objEmail = new serverEmail();
    $msg = [];

    $dataEmail = $objEmail->leerConfig();
    if (!empty($dataEmail)) {
        $emailDestino = $data['email'];
        $asunto = $data['asunto'];
        $nombre = $data['nombre'];
        ob_start();
        require_once("Views/App/Template/Email/" . $template . ".php");
        $mensaje = ob_get_clean();
        try {
            //Server settings
            // $mail->SMTPDebug = mostrar debug: 0 no mostrar: 1;
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            // $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->Host       = $dataEmail['em_host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $dataEmail['em_usermail'];                     //SMTP username
            $mail->Password   = $dataEmail['em_pass'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $dataEmail['em_port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = "UTF-8";
            $mail->setLanguage('es', 'vendor/phpmailer/phpmailer/language/');      //To load the French version

            //Recipients
            $mail->setFrom($dataEmail['em_usermail'], NOMBRE_EMPRESA);
            $mail->addAddress($emailDestino, $nombre);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('leenh@leenhcraft.com', 'Information');
            $mail->addCC('leenh@leenhcraft.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments - archivos adjuntos
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content - mensaje
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;
            $mail->AltBody = 'leenhcraft.com';
            $mail->charSet = "UTF-8";

            $mail->send();
            $msg['status'] = true;
            $msg['text'] = 'Mensaje enviado';
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $msg['status'] = false;
            $msg['text'] = "No se pudo enviar el mensaje. Error de correo: {$mail->ErrorInfo}";
        }
    } else {
        $msg['status'] = false;
        $msg['text'] = "No se a configurado un servidor de email";
    }
    return $msg;
}

function menus()
{
    require_once "Models/NivelesModel.php";
    $nivel = new NivelesModel();
    $data = $nivel->menus($_SESSION['lnh_r']);
    return $data;
}

function submenus(int $idmenu)
{
    require_once "Models/NivelesModel.php";
    $nivel = new NivelesModel();
    $data = $nivel->submenus($idmenu);
    return $data;
}

function getPermisos($idmod)
{
    require_once 'Models/NivelesModel.php';
    $obj = new NivelesModel();
    return $obj->getPermisosMod(strtolower($idmod));
}

function pertenece($submen, $menu)
{
    require_once 'Models/NivelesModel.php';
    $obj = new NivelesModel();
    $request = $obj->pertenece($submen, $menu);
    return (!empty($request)) ? true : false;
}

function validar_clave($clave, &$error_clave)
{
    if (strlen($clave) < 6) {
        $error_clave = "La clave debe tener al menos 6 caracteres";
        return false;
    }
    if (strlen($clave) > 16) {
        $error_clave = "La clave no puede tener más de 16 caracteres";
        return false;
    }
    if (!preg_match('`[a-z]`', $clave)) {
        $error_clave = "La clave debe tener al menos una letra minúscula";
        return false;
    }
    if (!preg_match('`[A-Z]`', $clave)) {
        $error_clave = "La clave debe tener al menos una letra mayúscula";
        return false;
    }
    if (!preg_match('`[0-9]`', $clave)) {
        $error_clave = "La clave debe tener al menos un caracter numérico";
        return false;
    }
    if (!preg_match('/[@#$%&;*]/', $clave)) {
        $error_clave = "La clave debe tener al menos un caracter especial del tipo @, #, $, %, &, *";
        return false;
    }
    if (preg_match('/([0-9]+).*\1{2}/', $clave)) {
        $error_clave = "La clave no debe tener un número que se repita más de una vez.";
        return false;
    }
    // [@#$%&;*]
    $error_clave = "";
    return true;
}

function getModal($ruta, $data = "")
{
    $view_modal = "Views/App/Template/Modals/{$ruta}.php";
    require_once $view_modal;
}

function consultaDNI($dni)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://apiperu.dev/api/dni/$dni",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer 3fe97dac2bd89bddf396d1b284801fbb5a4c4d628e964fc9b64145635578848d"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;
}


// Obtener nomnre de usuario
function getName(int $id)
{
    require_once("Models/PermisosModel.php");
    $objPermisos = new PermisosModel();
    $arrPermisos = $objPermisos->bscUsu($id);
    if ($arrPermisos['rol'] == 'Root') {
        $arrPermisos['rol'] = '<span class="badge badge-danger">' . $arrPermisos['rol'] . '</span>';
    } else if ($arrPermisos['rol'] == 'Administrador') {
        $arrPermisos['rol'] = '<span class="badge badge-success">' . $arrPermisos['rol'] . '</span>';
    } else {
        $arrPermisos['rol'] = '<span class="badge badge-info">' . $arrPermisos['rol'] . '</span>';
    }
    return $arrPermisos;
}
