<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Resetar Senha - <?php echo $nomeSistema ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
      <div class="card-body login-card-body">
        <p class="login-box-msg">Resetar Senha</p>

        <form id="resetarSenha" action="" method="post">
          <div class="input-group mb-2">
            <input type="cpf" class="form-control" name="cpf" placeholder="cpf" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-2">
              <input type="hidden" name="Acao" value="resetarSenha">
              <button type="submit" class="btn btn-primary btn-block">Resetar senha</button>
              <a href="<?php echo $baseUrl ?>" class="btn btn-warning btn-block">Voltar</a>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?php echo $baseUrl ?>">Já sou cadastrado</a>
        </p>
      </div>
    </div>
  </div>


    <script src="<?php echo $baseUrl ?>app/public/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-aio-2.7.0.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/plugins/inputmask/jquery.inputmask.js"></script>
    <script src="<?php echo $baseUrl ?>app/public/js/adminlte.min.js"></script>
</body>

</html>


<script>
  $("#resetarSenha").submit(function(e) {
    e.preventDefault();
    Notiflix.Loading.Pulse('Carregando...');
    $.ajax({
      type: "POST",
      url: "<?php echo $baseUrl ?>resetar",
      data: $("#resetarSenha").serialize(),
      success: function(data) {
        debugger;
        if (data.acao == 'ok') {
          Notiflix.Report.Success('Sucesso!','Sua senha foi resetada com sucesso','Ok',
          function(){
            window.location.href = "./";
          });
          Notiflix.Loading.Remove();
        } else {
          Notiflix.Report.Failure('E-mail Invalido','Este e-mail não existe em nossa base','Ok');
          Notiflix.Loading.Remove();
        }
      }
    });
  });
</script>