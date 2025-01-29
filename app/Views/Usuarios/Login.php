<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $nomeSistema ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">
  <style>
        .btn-primary {
          background-color: <?php echo $corSecundaria.'95'?>;
          border: 1px solid <?php echo $corSecundaria.'60' ?>;
        }

        .btn-primary:hover{
          background-color: <?php echo $corSecundaria ?>;
          border: 1px solid <?php echo $corSecundaria ?>;
        }
    </style>
</head>

<body class="hold-transition login-page" style="background-image: linear-gradient(<?php echo  $corSecundaria . ',' . $corPrimaria ?>);">
  <div class="login-box">
    <div class="card">
      <div class="card-header text-center" style="background: <?php echo $corPrimaria ?>">
        <?php if ($urlLogo) {
          echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '">';
        } else {
          echo '<h2>' . $nomeSistema . '</h2>';
        }
        ?>
      </div>
      <div class="card-body  login-card-body">
        <p class="login-box-msg">Faça o seu login a baixo</p>

        <form id="login" action="" method="post">
          <div class="input-group mb-3">
            <input type="cpf" class="form-control" name="cpf" placeholder="CPF" value="" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-hashtag"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="senha" placeholder="Senha" value="" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-2">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>

          </div>

        </form>

        <p class="mb-1">
          <a href="<?php echo $baseUrl ?>resetar-senha">Esqueci minha senha</a>
        </p>
        <p class="mb-0">
          <a href="<?php echo $baseUrl ?>registro" class="text-center">Cadastre-se</a>
        </p>
      </div>
    </div>
  </div>

  <script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo $baseUrl ?>app/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
  <script src="<?php echo $baseUrl ?>app/public/js/adminlte.min.js"></script>
</body>
</html>

<script>

  $("#login").submit(function(e) {
    e.preventDefault();
    Notiflix.Loading.Pulse('Carregando...');
    $.ajax({
      type: "POST",
      url: "<?php echo $baseUrl ?>login",
      data: $("#login").serialize(),
      success: function(data) {
        if (data.resultado == 'erro') {
          Notiflix.Notify.Failure(data.msg);
          Notiflix.Loading.Remove();
          setTimeout(function() {
            location.reload();
          }, 2000);
        } else if (data.resultado == 'bloqueado') {
          Notiflix.Loading.Remove();
          Notiflix.Report.Warning(
            'Atenção!',
            'Seu usuário está inativo. Entre em contato com o administrador do sistema.',
            'Ok');
        } else if (data.resultado == 'aguardando') {
          Notiflix.Loading.Remove();
          Notiflix.Report.Warning(
            'Atenção!',
            'Seu usuário está em analise por favor aguarde.',
            'Ok');
        } else if (data.resultado == 'reprovado') {
          Notiflix.Loading.Remove();
          Notiflix.Report.Warning(
            'Atenção!',
            'Seu usuário foi reprovado favor entrar em contato com seu líder.',
            'Ok');
        } else {
          window.location.href = "/";
        }
      },
      error: function(error) {
        console.error("Erro na requisição AJAX:", error);
      }
    });
  });

</script>