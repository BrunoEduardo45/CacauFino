<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">

            <div class="col-md-12">
                <!-- Default box -->
                <div class="card card-outline card-primary">

                    <div class="card-body">
                        <h3>Usuários cadastrados</h3>
                        <hr>
                        <div class="col-md-12">
                            <?php

                            $joins = [
                                'INNER JOIN tipo_usuario ON (usu_tipo = tp_id)',
                                'INNER JOIN status ON (sts_id = usu_status)'
                            ];

                            $list = selecionarDoBanco('usuarios', '*', '', [], $joins);

                            if (count($list) > 0) { ?>

                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Id</th>
                                                <th style="width: 25%">Nome</th>
                                                <th style="width: 25%">Email</th>
                                                <th style="width: 20%">Celular</th>
                                                <th style="width: 10%">Tipo</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 5%">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">

                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo $values['usu_id'] ?></td>
                                                    <td><?php echo $values['usu_nome'] ?></td>
                                                    <td><?php echo $values['usu_email'] ?></td>
                                                    <td><?php echo $values['usu_celular'] ?></td>
                                                    <td><?php echo $values['tp_nome'] ?></td>
                                                    <td>
                                                        <?php if ($values['sts_nome'] == 'Aprovado') {
                                                            echo '<span class="badge badge-pill badge-success">Aprovados</span>';
                                                        } else if ($values['sts_nome'] == 'Bloqueado') {
                                                            echo '<span class="badge badge-pill badge-dark">Bloqueado</span>';
                                                        } else if ($values['sts_nome'] == 'Reprovado') {
                                                            echo '<span class="badge badge-pill badge-danger">Reprovado</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill badge-warning">Aguardando</span>';
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle btn-sm btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item" onclick="editarUsuario(this)" href="#" data-acao="visualizar"><i class="fas fa-pen-alt"></i> Editar</a>
                                                            <a class="dropdown-item" onclick="editarUsuario(this)" href="#" data-acao="resetarSenha"><i class="fas fa-key"></i> Resetar senha</a>
                                                            <?php if ($tipo == 1) { ?>
                                                                <a class="dropdown-item" onclick="editarUsuario(this)" href="#" data-acao="deletar"><i class="far fa-trash-alt"></i> Deletar uruário</a>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                                echo "Sem dados cadastrados";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <a class='btn btn-primary btn-block' href="<?php echo $baseUrl ?>cadastrar-usuario"><i class="fas fa-plus"></i> Cadastrar usuario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="usuarioModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Membro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="Usuario" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" />
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" id="nome" name="nome" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="telefone">Telefone</label>
                                            <input type="text" id="telefone" name="telefone" class="form-control telefone" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="celular">Celular</label>
                                            <input type="text" id="celular" name="celular" class="form-control celular" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sexo">Sexo</label>
                                            <select class="form-control" id="sexo" name="sexo">
                                                <option value="masculino">Masculino</option>
                                                <option value="feminino">Feminino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <?php
                                                $list = selecionarDoBanco('status', '*', 'sts_status = :status', [':status' => 1]);
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['sts_id'] ?>"><?php echo $values['sts_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="Acao" name="Acao" value="AdmUpdate">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<script>

    $('#tipo').on('change', function() {
        var tipo = $('#tipo').val();

        if (tipo == 4) {
            $("#geracao").attr('style', 'display:block');
        } else {
            $("#geracao").attr('style', 'display:none');
            $("#geracao_id").val('0');
        }
    });

    function editarUsuario(e) {
        event.preventDefault();

        var linha = $(e).closest("tr");
        var id = linha.find("td:eq(0)").text().trim();
        var email = linha.find("td:eq(2)").text().trim();
        var acao = $(e).data("acao");

        Notiflix.Loading.Pulse('Carregando...');

        if (acao == "visualizar") {
            $.ajax({
                url: '/visualizar',
                data: {
                    'Id': id
                },
                type: "POST",
                success: function(data) {
                    Notiflix.Loading.Remove();
                    $("#id").val(id);
                    $("#nome").val(data[0].usu_nome);
                    $("#email").val(data[0].usu_email);
                    $("#sexo").val(data[0].usu_sexo);
                    $("#telefone").val(data[0].usu_telefone);
                    $("#celular").val(data[0].usu_celular);
                    $("#status").val(data[0].usu_status);
                    $("#tipo").val(data[0].usu_tipo);
                    $('#usuarioModal').modal('show');
                },
                error: function(error) {
                    Notiflix.Loading.Remove();
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        }

        if (acao == "deletar") {
            Notiflix.Loading.Remove();
            Notiflix.Confirm.Show(
                'Deletar Usuário',
                'Tem certeza que deseja deletar este usuário?',
                'Sim', 'Não',
                function() {
                    Notiflix.Loading.Pulse('Carregando...');
                    $.ajax({
                        url: '/deletar-usuario',
                        data: {
                            'Id': id,
                        },
                        type: "POST",
                        success: function(data) {
                            Notiflix.Loading.Remove();
                            if (data.acao == 'deletado') {
                                Notiflix.Notify.Success('Usuário Deletado');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }
                        },
                        error: function(error) {
                            // Lida com erros, se houverem
                            debugger;
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });
                }
            );
        }

        if (acao == "resetarSenha") {
            Notiflix.Loading.Remove();
            Notiflix.Confirm.Show(
                'Resetar Senha',
                'Tem certeza que deseja resetar a senha?',
                'Sim', 'Não',
                function() {
                    Notiflix.Loading.Pulse('Carregando...');
                    $.ajax({
                        url: '/resetar-senha',
                        data: {
                            'email': email
                        },
                        type: "POST",
                        success: function(data) {
                            Notiflix.Loading.Remove();
                            if (data.acao == 'ok') {
                                Notiflix.Notify.Success('Senha resetada com sucesso!');
                            } else {
                                Notiflix.Notify.Error('erro!');
                            }
                        },
                        error: function(error) {
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });
                });
        }

    };

    function Dados()
    {
        return {
            'usu_nome': $('#nome').val() ?? null, 
            'usu_email': $('#email').val() ?? null, 
            'usu_telefone': $('#telefone').val() ?? null, 
            'usu_celular': $('#celular').val() ?? null, 
            'usu_sexo': $('#sexo').val() ?? null, 
            'usu_status': $('#status').val() ?? null, 
        };
    }

    $("#Usuario").submit(function(e) {
        debugger;
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "/update-adm",
            data: {
                id: $('#id').val(),
                dados: Dados()
            },
            success: function(data) {
                if (data.success == 'Atualizado com sucesso!') {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Usuário atualizado com Sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg);
                    Notiflix.Loading.Remove();
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