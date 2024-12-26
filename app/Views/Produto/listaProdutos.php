<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Cadastrar produto</h3>
                        <hr>
                        <div class="col-md-12">
                            <form id="form" method="post">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="" />
                                    <div class="col-lg-6">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="titulo">Título</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="preco">Preço</label>
                                            <input type="text" class="form-control" id="preco" name="preco" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="qtd">Quantidade</label>
                                            <input type="text" class="form-control" id="qtd" name="qtd" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="descricao">Descricao</label>
                                            <input type="text" class="form-control" id="descricao" name="descricao" value="" required>
                                        </div>
                                    </div>
                                    <div id="step04" class="col-lg-6">
                                        <div class="form-group">
                                            <label>Unidade</label>
                                            <select class="form-control" id="unidade" name="unidade">
                                                <option value="">Selecionar</option>
                                                <option value="Unidades">Unidades</option>
                                                <option value="Quilos">Quilos</option>
                                                <option value="Metros">Metros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="step04" class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1">Ativo</option>
                                                <option value="0">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mt-6">
                                            <label class="form-label" for="cadastro"></label>
                                            <button type="submit" id="cadastro" name="cadastro" class="btn btn-primary btn-block" data-acao="salvar"><i class="fas fa-plus"></i> Cadastrar</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mt-6">
                                            <label class="form-label" for="limpar"></label>
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block"><i class="fas fa-eraser"></i> Limpar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <h3>Produtos cadastrados</h3>
                            <hr>
                            <?php
                            $list = selecionarDoBanco('produto');
                            $count = count($list);
                            if ($count > 0) { ?>
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">ID</th>
                                                <th style="width: 40%">Titulo</th>
                                                <th style="width: 15%">Valor</th>
                                                <th style="width: 15%">Qtd</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">
                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo $values['prod_id'] ?></td>
                                                    <td><?php echo $values['prod_titulo'] ?></td>
                                                    <td><?php echo 'R$' . $values['prod_preco'] ?></td>
                                                    <td><?php echo $values['prod_quantidade'] . ' ' . $values['prod_unidade'] ?></td>
                                                    <td><?= ($values['prod_status'] == 1) ? '<span class="badge badge-pill badge-success">Ativo</span>' : '<span class="badge badge-pill badge-danger">Inativo</span>'; ?></td>
                                                    <td>
                                                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['prod_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></a>
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['prod_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></a>
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
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Dados() {
        return {
            'prod_titulo': $('#titulo').val() ?? null,
            'prod_descricao': $('#descricao').val() ?? null,
            'prod_preco': $('#preco').val().replace(/[^\d,.-]/g, '').replace(',', '.') ?? null, 
            'prod_quantidade': $('#qtd').val() ? parseInt($('#qtd').val(), 10) : null, 
            'prod_unidade': $('#unidade').val() ?? null,
            'prod_status': $('#status').val() ?? null,
        };
    }

    $(document).ready(function () {
        Inputmask({
            alias: "numeric",
            groupSeparator: ".",
            radixPoint: ",",
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            prefix: "R$ ",
            placeholder: "0",
            rightAlign: false
        }).mask("#preco");
    });

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
                        url: '/deletar-produtos',
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
                url: '/editar-produtos',
                data: {
                    'id': $(this).data('id'),
                    'acao': $(this).data('acao')
                },
                type: "POST",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $("#id").val(data[0].prod_id);
                        $("#titulo").val(data[0].prod_titulo);
                        $("#descricao").val(data[0].prod_descricao);

                        let precoFormatado = parseFloat(data[0].prod_preco).toFixed(2).replace('.', ',');
                        $("#preco").val(precoFormatado);

                        $("#qtd").val(data[0].prod_quantidade);
                        $("#unidade").val(data[0].prod_unidade);
                        $("#status").val(data[0].prod_status);
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
            var url = "/cadastrar-produtos"
        } else {
            var url = "/atualizar-produtos"
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
