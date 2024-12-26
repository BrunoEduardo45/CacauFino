<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">

            <div class="col-md-12">
                <!-- Default box -->
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3><?php echo __('video.cadastrar_video') ?></h3>
                        <hr>
                        <div class="col-md-12">

                            <form id="form" method="post">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="" />
                                    <div class="col-lg-3">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="titulo"><?php echo __('video.titulo_video') ?></label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="step01" class="form-group">
                                            <label class="form-label" for="url"><?php echo __('video.url_video') ?></label>
                                            <input type="url" class="form-control" id="url" name="url" value="" required>
                                        </div>
                                    </div>
                                    <div id="step04" class="col-lg-1">
                                        <div class="form-group">
                                            <label><?php echo __('video.categoria') ?></label>
                                            <select class="form-control" id="categoria" name="categoria">
                                                <?php
                                                $stmt = $pdo->prepare("SELECT * FROM categoria WHERE cat_status = 1");
                                                $stmt->execute();
                                                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['cat_id'] ?>"><?php echo $values['cat_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="step04" class="col-lg-1">
                                        <div class="form-group">
                                            <label><?php echo __('video.status') ?></label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1"><?php echo __('video.ativo') ?></option>
                                                <option value="0"><?php echo __('video.inativo') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group mt-2">
                                            <label class="form-label" for="cadastro"></label>
                                            <button type="submit" id="cadastro" name="cadastro" class="btn btn-primary btn-block" data-acao="salvar"><?php echo __('video.cadastrar') ?></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group mt-2">
                                            <label class="form-label" for="limpar"></label>
                                            <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block"><?php echo __('video.limpar') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <br>
                            <h3><?php echo __('video.videos_cadastrados') ?></h3>
                            <hr>
                            <?php

                            $stmt = $pdo->prepare("SELECT * FROM video INNER JOIN categoria ON (cat_id = vid_categoria_id)");
                            $stmt->execute();
                            $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $count = count($list);

                            if ($count > 0) { ?>

                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%"><?php echo __('video.id') ?></th>
                                                <th style="width: 30%"><?php echo __('video.titulo') ?></th>
                                                <th style="width: 10%"><?php echo __('video.categoria') ?></th>
                                                <th style="width: 30%"><?php echo __('video.url_youtube') ?></th>
                                                <th style="width: 10%"><?php echo __('video.status') ?></th>
                                                <th style="width: 10%"><?php echo __('video.acao') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">

                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo $values['vid_id'] ?></td>
                                                    <td><?php echo $values['vid_titulo'] ?></td>
                                                    <td><?php echo $values['cat_nome'] ?></td>
                                                    <td><?php echo $values['vid_url'] ?></td>
                                                    <td><?php echo ($values['vid_status'] == 1) ? '<span class="badge badge-pill badge-success">' . __('video.ativo') . '</span>' : '<span class="badge badge-pill badge-danger">' . __('video.inativo') . '</span>'; ?></td>
                                                    <td>
                                                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                            <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['vid_id'] ?>" data-acao="editar"><i class="fas fa-pen-alt"></i></a>
                                                            <?php if ($nivel == 1) { ?>
                                                                <a href="#" class="btn btn-sm btn-secondary editarBtn" data-id="<?php echo $values['vid_id'] ?>" data-acao="deletar"><i class="far fa-trash-alt"></i></a>
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
                                echo __('video.sem_dados');
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
            'vid_titulo': $('#titulo').val() ?? null,
            'vid_categoria_id': $('#categoria').val() ?? null,
            'vid_url': $('#url').val() ?? null,
            'vid_status': $('#status').val() ?? null,
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
                        url: '/deletar-video',
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
                url: '/editar-video',
                data: {
                    'id': $(this).data('id'),
                    'acao': $(this).data('acao')
                },
                type: "POST",
                success: function(data) {
                    if (data.acao == 'editar') {
                        $("#id").val(data.id);
                        $("#titulo").val(data.titulo);
                        $("#categoria").val(data.categoria);
                        $("#url").val(data.url);
                        $("#status").val(data.status);
                        $("#cadastro").attr('data-acao', 'atualizar');
                        $("#cadastro").text('<?php echo $pais == 1 ? 'Atualizar' : 'Update' ?>');
                        debugger;
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
            var url = "/cadastrar-video"
        } else {
            var url = "/atualizar-video"
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': $("#id").val(),
                'dados': Dados()
            },
            success: function(data) {
                //debugger;
                if (data.success != '' && acao == "salvar") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Cadastrado com Sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (data.success != '' && acao != "salvar") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Atualizada com Sucesso!');
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