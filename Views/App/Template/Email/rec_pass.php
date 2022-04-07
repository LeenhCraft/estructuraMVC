<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Hola <b><?php echo $data['nombre']; ?></b>, <br>
    Se ha solicitado recuperar la contraseña de este email:<br>
    <b><?php echo $data['email']; ?></b><br>
    
    Tus credenciales de acceso son:<br>
    Usuario: <b><?php echo $data['usuario']; ?></b><br>
    Contraseña: <b><?php echo $data['password']; ?></b><br>
    Te recomendamos cambiar tu contraeña al ingresar a la plataforma.
</body>

</html>