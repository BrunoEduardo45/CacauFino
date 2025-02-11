<div class="content-wrapper">

    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Cadastrar Cacau</h3>
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
                                        <div class="form-group">
                                            <label>Tipo de Cacau</label>
                                            <select class="form-control" id="tipo_cacau" name="tipo_cacau">
                                                <option value="">Selecionar</option>
                                                <option value="Comum">Comum</option>
                                                <option value="Especial">Especial</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Tipo de Anúncio</label>
                                            <select class="form-control" id="tipo_anuncio" name="tipo_anuncio">
                                                <option value="">Selecionar</option>
                                                <option value="Venda">Venda</option>
                                                <option value="Compra">Compra</option>
                                            </select>
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
                                    <div id="step04" class="col-lg-3">
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
                                    <div id="step04" class="col-lg-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1">Ativo</option>
                                                <option value="0">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" id="estado" name="estado" onchange="carregarCidades()">
                                                <option value="">Selecionar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cidade</label>
                                            <select class="form-control" id="cidade" name="cidade">
                                                <option value="">Selecionar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="descricao">Descricao</label>
                                            <input type="text" class="form-control" id="descricao" name="descricao" value="" required>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content pt-2">
        <div class="container-fluid">    
            <div class="col-md-12">       
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Cacaus cadastrados</h3>
                        <hr>
                        <?php
                            $list = selecionarDoBanco('cacau');
                            $count = count($list);
                            if ($count > 0) { 
                        ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover table-sm w-100">
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
                                                <td><?php echo $values['cac_id'] ?></td>
                                                <td><?php echo $values['cac_titulo'] ?></td>
                                                <td><?php echo 'R$' . $values['cac_preco'] ?></td>
                                                <td><?php echo $values['cac_quantidade'] . ' ' . $values['cac_unidade'] ?></td>
                                                <td><?= ($values['cac_status'] == 1) ? '<span class="badge badge-pill badge-success">Ativo</span>' : '<span class="badge badge-pill badge-danger">Inativo</span>'; ?></td>
                                                <td>
                                                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                        <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['cac_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></a>
                                                        <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['cac_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></a>
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
    </section>

</div>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados")
            .then(response => response.json())
            .then(estados => {
                estados.sort((a, b) => a.nome.localeCompare(b.nome));
                let selectEstado = document.getElementById("estado");
                estados.forEach(estado => {
                    let option = new Option(estado.nome, estado.id);
                    selectEstado.add(option);
                });
            });
    });

    function carregarCidades() {
        let estadoId = document.getElementById("estado").value;
        let selectCidade = document.getElementById("cidade");
        selectCidade.innerHTML = "<option value=''>Selecionar</option>";

        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
            .then(response => response.json())
            .then(cidades => {
                cidades.forEach(cidade => {
                    let option = new Option(cidade.nome, cidade.id);
                    selectCidade.add(option);
                });
            });
    }

    function Dados() {
        return {
            'cac_titulo': $('#titulo').val() ?? null,
            'cac_descricao': $('#descricao').val() ?? null,
            'cac_preco': $('#preco').val().replace(/[^\d,.-]/g, '').replace(',', '.') ?? null, 
            'cac_quantidade': $('#qtd').val() ? parseInt($('#qtd').val(), 10) : null, 
            'cac_unidade': $('#unidade').val() ?? null,
            'cac_status': $('#status').val() ?? null,
            'cac_situacao': 2,
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
                        url: '/deletar-cacau',
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
                url: '/editar-cacau',
                data: {
                    'id': $(this).data('id'),
                    'acao': $(this).data('acao')
                },
                type: "POST",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $("#id").val(data[0].cac_id);
                        $("#titulo").val(data[0].cac_titulo);
                        $("#descricao").val(data[0].cac_descricao);

                        let precoFormatado = parseFloat(data[0].cac_preco).toFixed(2).replace('.', ',');
                        $("#preco").val(precoFormatado);

                        $("#qtd").val(data[0].cac_quantidade);
                        $("#unidade").val(data[0].cac_unidade);
                        $("#status").val(data[0].cac_status);
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
            var url = "/cadastrar-cacau"
        } else {
            var url = "/atualizar-cacau"
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
