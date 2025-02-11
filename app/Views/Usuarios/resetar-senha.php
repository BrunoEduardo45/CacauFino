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

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="app/public/css/main.css" rel="stylesheet">

  <style>
        .btn-primary {
          background-color: <?php echo $corSecundaria.'95'?>;
          border: 1px solid <?php echo $corSecundaria.'60' ?>;
        }

        .btn-primary:hover{
          background-color: <?php echo $corSecundaria ?>;
          border: 1px solid <?php echo $corSecundaria ?>;
        }
        
        .login-box {
            width: 100%;
            height: 100vh; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 100%;
            max-width: 400px; /* Define um tamanho máximo para a caixa de login */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adiciona um leve sombreado */
            border-radius: 10px; /* Bordas arredondadas */
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
      <div class="card-body login-card-body">
        <p class="login-box-msg">Resetar Senha</p>

        <form id="resetarSenha" action="" method="post">
          <div class="input-group mb-2">
            <input type="cpf" class="form-control" name="cpf" placeholder="CPF" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-hashtag"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-2">
              <input type="hidden" name="Acao" value="resetarSenha">
              <button type="submit" class="btn btn-primary btn-block">Resetar senha</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?php echo $baseUrl ?>login-page">Fazer login</a>
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
  <script src="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/script/c337de081b.js"></script>

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

</body>
</html>