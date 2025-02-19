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
    $comprador = decryptData($_COOKIE['comprador'], $encryptionKey);
    $vendedor  = decryptData($_COOKIE['vendedor'], $encryptionKey);
} else {
    $IdUser = $tipo = $nomeUser = $cpf = null;
}

$currentPage = basename($_SERVER['REQUEST_URI'], ".php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $nomeSistema ?></title>

  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="<?php echo $baseUrl ?>app/public/img/favicon.png" rel="icon">
  <link href="<?php echo $baseUrl ?>app/public/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Liter&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo $baseUrl ?>app/public/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo $baseUrl ?>app/public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $baseUrl ?>app/public/vendor/aos/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
  <link href="<?php echo $baseUrl ?>app/public/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Antigos --> 
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.css" type="text/css" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/icons/css/bootstrap-iconpicker.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/cropper/cropper.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/colorpicker/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.css">
  
  <!-- Chart.js (versão 3 ou 4) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">


  <!-- Main CSS File -->
  <link href="app/public/css/main.css" rel="stylesheet">

  <style>
    @media print {
      @page {
        size: landscape;
      }
    }

    body {
      background-color: #d0d4a44d;
    }

    .table-primary, .btn-primary, .btn-outline-primary, .badge-primary, .alert-primary, .list-group-item-primary, 
    .bg-primary, .border-primary {
      background-color: <?php echo $corSecundaria ?>;
      border: 1px solid <?php echo $corSecundaria ?>;
    }

    .card-primary.card-outline {
      border-top: 3px solid <?php echo $corSecundaria ?>;
    }

    .btn-primary:hover, .btn-outline-primary:hover, .badge-primary:hover, .list-group-item-primary:hover {
      background-color: <?php echo $corSecundaria.'99' ?>;
      border: 1px solid <?php echo $corSecundaria.'05' ?>;
    }

    .navbar-nav .nav-link.active {
      font-weight: bold;
      color: <?php echo $corSecundaria ?> !important;
      transition: all 0.3s ease-in-out;
    }

    h1, h2, h3, h4, h5 {
      color: <?php echo $corSecundaria ?>;
    }

    .descricao-limitada {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      color: #202122;
    }

    .pagination .page-item .page-link {
      color: <?php echo $corSecundaria ?>;
    }

    .pagination .page-item .page-link:hover {
      background-color: <?php echo $corSecundaria . '30' ?>;
    }

    .pagination .page-item.active .page-link {
      background-color: <?php echo $corPrimaria ?>;
      border-color: <?php echo $corPrimaria ?>;
    }

    section {
      background-color: #fff0;
    }

    .card-cotacao {
      background: #fdfdfc; 
      border-radius: 10px; 
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
      padding: 10px;
      margin: 0 auto; 
      position: relative; 
      transition: transform 0.2s;
    }

    .card-cotacao:hover {
      transform: scale(1.02);
    }

    .card-cotacao a {
      text-decoration: none;
      color: inherit;
    }

    .card-cotacao .post-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 5px 5px 0 0;
    }

    .card-cotacao .p-3 {
      padding: 15px;
    }

    .card-cotacao .titulo {
      font-weight: bold;
      font-size: 1.2em;
    }

    .card-cotacao .descricao-limitada {
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }

    .header-cotacao {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .header-cotacao img {
      width: 40px;
      height: 40px;
      margin-right: 10px;
    }

    .header-cotacao .titulo, .titulo {
      font-size: 1.2rem;
      font-weight: bold;
      color: <?php echo $corSecundaria ?>; 
    }

    .info-preco {
      font-size: 1.5rem;
      font-weight: 700;
      color: <?php echo $corSecundaria ?>; 
      margin-right: 20px;
    }

    .info-variacao {
      color: red; 
      font-weight: 700;
      margin-right: 10px;
    }

    .grafico-container {
      width: 100%;
      height: 200px;
      position: relative;
    }

    canvas {
      width: 100% !important;
      height: 200px !important;
    }

    .post-img img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 10px 10px 0 0;
    }

    .titulo {
      font-size: 1.1rem;
      font-weight: bold;
      color: <?php echo $corSecundaria ?>; 
    }

    .descricao-limitada {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      color: <?php echo $corSecundaria ?>;
    }

    .btn-outline-dark {
      border-color: <?php echo $corSecundaria ?>;
      color: <?php echo $corSecundaria ?>;
    }

    .btn-outline-dark:hover {
      background-color: <?php echo $corSecundaria ?>;
      color: #fff;
    }

    /* Faz com que cada slide possa ter pseudo-elemento com gradiente */
    .swiper-slide {
      position: relative;
      overflow: hidden; 
    }

    /* Personaliza os botões de navegação */
    .swiper-button-prev,
    .swiper-button-next {
      color: #fff; 
    }

    .swiper-button-prev {
      left: 10px;
    }

    .swiper-button-next {
      right: 10px;
    }

    /* Paginação (bolinhas) */
    .swiper-pagination-bullet {
      background: rgba(255, 255, 255, 0.7);
    }

    .swiper-pagination-bullet-active {
      background: #fff;
    }

    /* cor imagem */
    .swiper-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      filter: brightness(0.5);
    }
  </style>

</head>

<body class="index-page">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<header id="header" class="d-flex flex-column align-items-center position-relative w-100"  style="background-color: #fff;">

    <!-- Menu Principal -->
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between py-3">

        <a href="<?php echo $baseUrl ?>" class="navbar-brand d-flex align-items-center">
            <?php if ($urlLogo) {
                echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" style="max-width: 200px;">';
            } else {
                echo '<span class="brand-text font-weight-light ml-3">' . $nomeSistema . '</span>';
            } ?>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav">

                    <?php if ($IdUser !== null) { ?>
                        <li class="nav-item"><a href="<?php echo $baseUrl ?>produtos" class="nav-link <?php echo ($currentPage == 'produtos') ? 'active' : ''; ?>">PRODUTOS</a></li>
                        <li class="nav-item"><a href="<?php echo $baseUrl ?>cacaus" class="nav-link <?php echo ($currentPage == 'cacaus') ? 'active' : ''; ?>">CACAU</a></li>
                    <?php } ?>

                    <li class="nav-item"><a href="<?php echo $baseUrl ?>noticias" class="nav-link <?php echo ($currentPage == 'noticias') ? 'active' : ''; ?>">NOTÍCIAS</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>cotacoes" class="nav-link <?php echo ($currentPage == 'cotacoes') ? 'active' : ''; ?>">COTAÇÕES</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>eventos" class="nav-link <?php echo ($currentPage == 'eventos') ? 'active' : ''; ?>">EVENTOS</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>blog" class="nav-link <?php echo ($currentPage == 'blog') ? 'active' : ''; ?>">BLOG</a></li>

                    <?php if ($IdUser !== null) { ?>
                        <li class="nav-item"><a href="<?php echo $baseUrl ?>servicos" class="nav-link <?php echo ($currentPage == 'servicos') ? 'active' : ''; ?>">SERVIÇOS</a></li>
                    <?php } ?>

                    <li class="nav-item"><a href="<?php echo $baseUrl ?>sobre" class="nav-link <?php echo ($currentPage == 'sobre') ? 'active' : ''; ?>">SOBRE</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>contato" class="nav-link <?php echo ($currentPage == 'contato') ? 'active' : ''; ?>">CONTATOS</a></li>

                </ul>
            </div>
        </nav>

        <?php if ($IdUser !== null) { ?>
          <div class="dropdown">
              <a id="dropdownUser" href="#" class="btn btn-outline-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user-circle"></i> 
                  <span class="d-none d-md-inline"><?php echo $nomeUser ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                  <li><a class="dropdown-item" href="<?php echo $baseUrl ?>editUsuario">Perfil</a></li>
                  <li><a class="dropdown-item text-danger" href="<?php echo $baseUrl."logout/".$IdUser ?>">Sair</a></li>
              </ul>
          </div>
        <?php } else { ?>
            <a href="<?php echo $baseUrl ?>login-page" class="btn btn-outline-secondary">
                <i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline">Fazer login</span>
            </a>
        <?php } ?>

    </div>

    <!-- Menu Inferior -->
    <nav class="navbar navbar-expand-lg navbar-light  w-100" style="background-color: <?php echo $corPrimaria ?>;">
        <div class="container-fluid justify-content-center">

            <?php if ($IdUser !== null) { ?>
                <ul class="navbar-nav d-flex w-100  justify-content-between container">
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>dashboard" class="nav-link"><i class="bi bi-house"></i> DASHBOARD</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>cadastrar-noticia" class="nav-link"><i class="bi bi-plus-square"></i> PUBLICAR</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-pencil"></i> CADASTROS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>lista-cacau">Cacau</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>lista-produtos">Produtos</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>lista-noticias">Publicações</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>lista-categorias">Categorias</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-check-circle"></i> APROVAÇÕES
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>tela-comentarios">Comentários</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>tela-postagens">Publicações</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>tela-cacau">Cacau</a></li>
                            <li><a class="dropdown-item" href="<?php echo $baseUrl ?>tela-produtos">Produtos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>lista-usuarios" class="nav-link"><i class="bi bi-people"></i> USUARIOS</a></li>
                    <li class="nav-item"><a href="<?php echo $baseUrl ?>configuracao" class="nav-link"><i class="bi bi-gear"></i> CONFIGURAÇÕES</a></li>
                </ul>
            <?php } ?>

        </div>
    </nav>

</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let links = document.querySelectorAll(".navbar-nav .nav-link");
        let currentUrl = window.location.href;
        links.forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add("active");
            }
        });
    });
</script>

<div class="container p-0">