<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- Default box -->
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Cadastrar Categoria</h3>
                        <hr>
                        <div class="col-md-12">
                            <form id="form" method="post">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="" />
                                    <div class="col-lg-6">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="cat_nome">Nome</label>
                                            <input type="text" class="form-control" id="cat_nome" name="cat_nome" value="" required>
                                        </div>
                                    </div>
                                    <div id="step04" class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="cat_status" name="cat_status">
                                                <option value="1">Ativo</option>
                                                <option value="0">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" id="cadastro" name="cadastro" class="btn btn-primary btn-block" data-acao="salvar"><i class="fas fa-plus"></i> Cadastrar</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block"><i class="fas fa-eraser"></i> Limpar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <h3>Categorias Cadastradas</h3>
                            <hr>
                            <?php
                            $list = selecionarDoBanco('categoria');
                            $count = count($list);
                            if ($count > 0) { ?>
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">ID</th>
                                                <th style="width: 70%">Nome</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">
                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo $values['cat_id'] ?></td>
                                                    <td><?php echo $values['cat_nome'] ?></td>
                                                    <td><?= ($values['cat_status'] == 1) ? '<span class="badge badge-pill badge-success">Ativo</span>' : '<span class="badge badge-pill badge-danger">Inativo</span>'; ?></td>
                                                    <td>
                                                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['cat_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></a>
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['cat_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                                echo "Nenhum dado cadastrado.";
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    function Dados()
    {
        // validação dos campos
        var dados = {
            'cat_nome': $('#cat_nome').val() ?? null,
            'cat_status': $('#cat_status').val() ?? null,
        };
        return dados;
    }

    $('.editarBtn').click(function() {
        event.preventDefault();
        var id = $(this).data('id');
        var acao = $(this).data('acao');

        if (acao == 'deletar') {
            Notiflix.Confirm.Show(
                'Deletar!',
                'Tem certeza que deseja deletar?',
                'Sim',
                'Não',
                function okCb() {
                    Notiflix.Loading.Pulse('Carregando...');
                    $.ajax({
                        url: '/deletar-categorias',
                        data: {
                            'id': id,
                            'acao': acao
                        },
                        type: "POST",
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            );
        } else {
            $.ajax({
                url: '/editar-categorias',
                data: {
                    'id': $(this).data('id'),
                    'acao': $(this).data('acao')
                },
                type: "POST",
                success: function(data) {
                    if (data.acao == 'editar') {
                        $("#id").val(data.id);
                        $("#cat_nome").val(data.nome);
                        $("#cat_status").val(data.status);
                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('Atualizar');
                    } else {
                        location.reload();
                    }

                }
            });
        }
    });

    $("#form").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        var acao = $('#cadastro').data('acao');

        if(acao == "salvar"){
            var url = "/cadastrar-categorias"
        } else {
            var url = "/atualizar-categorias"
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': $("#id").val(),
                'dados': Dados()
            },
            success: function(data) {
                if (data.success != "") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success(data.success);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.error);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                // Lida com erros, se houverem
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>
