<?php
$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

session_start();

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $IdUser    = decryptData($_COOKIE['id'], $encryptionKey);
    $tipo      = decryptData($_COOKIE['tipo'], $encryptionKey);
    $nomeUser  = decryptData($_COOKIE['usuario'], $encryptionKey);
    $cpf       = decryptData($_COOKIE['cpf'], $encryptionKey);
} else {
    $IdUser = $tipo = $nomeUser = $cpf = null;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $nomeSistema ?></title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/icons/css/bootstrap-iconpicker.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/cropper/cropper.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/colorpicker/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <style>
        @media print {
            @page {
                size: landscape;
            }
        }
        .table-primary, .btn-primary, .btn-outline-primary, .badge-primary, .alert-primary, .list-group-item-primary, 
        .bg-primary, .border-primary {
          background-color: <?php echo $corSecundaria ?>;
          border: 1px solid <?php echo $corSecundaria ?>;
        }

        .card-primary.card-outline {
          border-top: 3px solid <?php echo $corSecundaria ?>;
        }

        .btn-primary:hover, .btn-outline-primary:hover, .badge-primary:hover, .list-group-item-primary:hover{
          background-color: <?php echo $corSecundaria.'99' ?>;
          border: 1px solid <?php echo $corSecundaria.'05' ?>;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed pace-done">
<script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        
        <?php if ($IdUser !== null){ ?>
            <!-- Perfil do Usuário -->
            <li class="nav-item">
              <a id="<?php echo $baseUrl ?>editUsuario" href="usuario" class="nav-link border rounded mr-2">
                <i class="fas fa-user-circle"></i>
                <span class="d-none d-md-inline"><?php echo $nomeUser ?></span>
              </a>
            </li>
        <?php  } else { ?>
            <!-- Botão de Login -->
            <li class="nav-item">
              <a href="<?php echo $baseUrl ?>login-page" class="nav-link border rounded mr-2">
                <i class="fas fa-sign-in-alt"></i>
                <span class="d-none d-md-inline">Fazer login</span>
              </a>
            </li>
        <?php } ?>

        <!-- Botão Carrinho -->
        <li class="nav-item">
          <a href="#" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Meu carrinho
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <?php include 'sidebar.php' ?>

</div>