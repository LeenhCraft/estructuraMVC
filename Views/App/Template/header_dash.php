<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?php echo $data['titulo_web']; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <link rel="icon" type="image/png" href="<?php echo media(); ?>img/logo.png">

    <meta name="Author" lang="es" content="leenhcraft.com">

    <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
    <meta property="og:title" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:description" content="">

    <!-- Twitter Cards integration: https://dev.twitter.com/cards/  -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">

    <!-- <link rel="stylesheet" href="<?php echo media() . 'css/plugins/bootstrap.css'; ?>"> -->
    <link rel="stylesheet" href="<?php echo media() . 'css/main.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/font.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/sweetalert2.min.css'; ?>">

    <?php
    if (isset($data['css']) && !empty($data['css'])) {
        for ($i = 0; $i < count($data['css']); $i++) {
            echo '<link rel="stylesheet" type="text/css" href="' . media() . $data['css'][$i] . '">';
        }
    }
    ?>

</head>

<body class="app sidebar-mini">
    <div id="divLoading">
        <div>
            <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
        </div>
    </div>
    <?php require_once "nav.php"; ?>