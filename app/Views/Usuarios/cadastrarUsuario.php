<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <form id="formUsu" method="post">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3>Cadastrar usuário</h3>
                                <hr>
                                <div class="row">
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="email">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="tipo">Tipo de Usuário</label>
                                            <select class="form-control" id="tipo" name="tipo">
                                                <option value="">Selecione</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Padrão</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="telefone">Telefone</label>
                                            <input type="text" class="form-control telefone" id="telefone" name="telefone" placeholder="(99) 9999-9999">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="celular">Celular</label>
                                            <input type="text" class="form-control celular" id="celular" name="celular" placeholder="(99) 9999-9999">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="sexo">Sexo</label>
                                            <select class="form-control" id="sexo" name="sexo">
                                                <option value="">Selecione</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="feminino">Feminino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label" for="senha">Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="senha" name="senha" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Atenção! As senhas não estão iguais
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label" for="senha">Confirmar senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="confirmarSenha" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Atenção! As senhas não estão iguais
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }

        var senhaInput = document.getElementById("confirmarSenha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }
    }


    $("#confirmarSenha").blur(function() {
        let senha = $("#senha").val();
        let confirmarSenha = $("#confirmarSenha").val();
        //debugger
        if (senha != confirmarSenha) {
            $("#senha").addClass("is-invalid");
            $("#confirmarSenha").addClass("is-invalid");
        } else {
            $("#senha").removeClass("is-invalid");
            $("#confirmarSenha").removeClass("is-invalid");
            $("#senha").addClass("is-valid");
            $("#confirmarSenha").addClass("is-valid");
        }
    });

    function Dados()
    {
        return {
            'usu_nome': $('#nome').val() ?? null,
            'usu_email': $('#email').val() ?? null,
            'usu_tipo': $('#tipo').val() ?? null,
            'usu_telefone': $('#telefone').val() ?? null,
            'usu_celular': $('#celular').val() ?? null,
            'usu_sexo': $('#sexo').val() ?? null,
            'usu_senha': $('#senha').val() ?? null,
            'usu_status': 1,
        };
    }

    $("#formUsu").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "<?php echo $baseUrl ?>inserir-usuario",
            data: {dados: Dados()},
            success: function(data) {
                if (data.acao == 'ok') {
                    Notiflix.Loading.Remove();
                    Notiflix.Report.Success(
                        'Sucesso!',
                        'Seu cadastro foi realizado com sucesso!',
                        'Ok',
                        function() {window.location.href = "<?php echo $baseUrl ?>lista-usuarios";}
                    );
                } else {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Failure(data.msg);
                    return false;
                }
            },
            error: function(error) {
                // Lida com erros, se houverem
                debugger;
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>