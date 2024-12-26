<?php

$baseDir = dirname(__FILE__);
include $baseDir . "/../../utils/Database.php";

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - <?php echo $nomeSistema ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>app/public/css/adminlte.min.css">
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
            <p class="login-box-msg">Realize seu cadastro</p>

            <form id="cadastro" action="" method="post">
                <div class="form-group">
                    <label class="form-label" for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <label class="form-label" for="senha">Senha</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" value="">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <button type="submit" id="btnCadatro" class="btn btn-primary btn-block">Cadastrar</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="<?php echo $baseUrl ?>resetar-senha">Esqueceu a Senha?</a>
            </p>
            <p class="mb-0">
                <a href="<?php echo $baseUrl ?>login-page" class="text-center">Já tenho cadastro</a>
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
    
    function toggleSenha() {
      var senhaInput = document.getElementById("senha");
      if (senhaInput.type === "password") {
        senhaInput.type = "text";
      } else {
        senhaInput.type = "password";
      }
    }

    function Dados()
    {
        return {
            'usu_nome': $('#nome').val() ?? null,
            'usu_email': $('#email').val() ?? null,
            'usu_senha': $('#senha').val() ?? null,
            'usu_status': 2,
            'usu_tipo': 2,
        };
    }

    $("#cadastro").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        var email = $("#email").val();
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo $baseUrl ?>verificar",
            data: {email: email},
            success: function(data) {
                
                if (data.acao == 'ok') {
                    $("#email").addClass('is-valid');
                    $("#email").removeClass('is-invalid');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $baseUrl ?>inserir-usuario",
                        data: {dados: Dados()},
                        success: function(data) {
                            if (data.acao == 'ok') {
                                Notiflix.Loading.Remove();
                                Notiflix.Report.Success(
                                    'Sucesso!',
                                    'Seu cadastro foi realizado com sucesso! Aguarde liberação da nossa equipe de suporte.',
                                    'Ok',
                                    function() {window.location.href = "<?php echo $baseUrl ?>";}
                                );
                            } else {
                                Notiflix.Loading.Remove();
                                Notiflix.Notify.Failure(data.msg);
                                return false;
                            }
                        },
                        error: function(error) {
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });
                } else {
                    Notiflix.Loading.Remove();
                    $("#email").addClass('is-invalid');
                    $("#email").removeClass('is-valid');
                    Notiflix.Notify.Failure('Este e-mail já existe em nossa base!');
                    $("#email").focus();
                    return false;
                }
            },
            error: function(error) {
                console.error("Erro na requisição AJAX:", error);
            }

        });
    });
</script>