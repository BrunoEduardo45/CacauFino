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
        <div class="card-body  login-card-body">
            <p class="w-100 text-center">Realize seu cadastro</p>

            <form id="cadastro" action="" method="post">
                <div class="form-group">
                    <label class="form-label" for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
                </div>
                <label class="form-label" for="senha">Senha</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="form-label">Tipo de Usuário</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="comprador" name="comprador" value="1">
                        <label class="form-check-label" for="comprador">Sou Comprador</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="vendedor" name="vendedor" value="1">
                        <label class="form-check-label" for="vendedor">Sou Vendedor</label>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-12 mb-2">
                        <button type="submit" id="btnCadastro" class="btn btn-primary btn-block">Cadastrar</button>
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

<script src="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/script/c337de081b.js"></script>

<script>
    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        senhaInput.type = senhaInput.type === "password" ? "text" : "password";
    }

    function Dados() {
        return {
            'usu_nome': $('#nome').val() ?? null,
            'usu_cpf': $('#cpf').val() ?? null,
            'usu_senha': $('#senha').val() ?? null,
            'usu_status': 2,
            'usu_tipo': 2,
            'usu_comprador': $('#comprador').is(':checked') ? 1 : 0,
            'usu_vendedor': $('#vendedor').is(':checked') ? 1 : 0,
        };
    }

    $("#cadastro").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');
        
        var cpf = $("#cpf").val();
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo $baseUrl ?>verificar",
            data: {cpf: cpf},
            success: function(data) {
                if (data.acao === 'ok') {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $baseUrl ?>inserir-usuario",
                        data: {dados: Dados()},
                        success: function(data) {
                            if (data.acao === 'ok') {
                                Notiflix.Loading.Remove();
                                Notiflix.Report.Success(
                                    'Sucesso!',
                                    'Seu cadastro foi realizado com sucesso!',
                                    'Ok',
                                    function() { window.location.href = "<?php echo $baseUrl ?>"; }
                                );
                            } else {
                                Notiflix.Loading.Remove();
                                Notiflix.Notify.Failure(data.msg);
                            }
                        }
                    });
                } else {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Failure('Este CPF já existe em nossa base!');
                }
            }
        });
    });
</script>