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
  <link rel="stylesheet" href="<?php echo media() . 'css/plugins/bootstrap.css'; ?>">
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

<body>
  <div id="divLoading" style="display: none;">
    <div>
      <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <a class="navbar-brand font-logo" style="font-size: 1.35rem;" href="/"><?= NOMBRE_EMPRESA ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto d-none">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0 d-none">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
    <?php if (isset($_SESSION['pe_u'])) {
    ?>
      <a class="text-decoration-none mx-2 border p-2 rounded btn-outline-primary d-none d-md-block" href="/logout">Cerrar Sesión</a>
    <?php } ?>
  </nav>