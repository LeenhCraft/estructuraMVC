<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Hola <?php echo $data['nombre']; ?>, <br>
    <b>Para finalizar tu registro, por favor haz click en el siguiente enlace:</b> <br>
    <b><?php echo $data['url_recovery']; ?></b>
</body>

</html>