<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3 class="col-12">Postagens para Aprovação</h3>
                        <hr>
                        <div class="col-md-12">
                            <?php
                            $joins = [
                                'INNER JOIN categoria ON (cat_id = not_categoria)', 
                                'INNER JOIN usuarios ON (usu_id = not_usuario_id)'
                            ];

                            $list = selecionarDoBanco('noticias', '*', 'not_situacao = 2', [], $joins);
                            $count = count($list);

                            if ($count > 0) { ?>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Título</th>
                                                <th>Categoria</th>
                                                <th>Responsável</th>
                                                <th>Status</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list as $values) { ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?></td>
                                                    <td><?php echo $values['not_titulo'] ?></td>
                                                    <td><?php echo $values['cat_nome'] ?></td>
                                                    <td><?php echo $values['usu_nome'] ?></td>
                                                    <td>
                                                        <?= ($values['not_status'] == 1) ? 
                                                            '<span class="badge badge-pill badge-success">Ativo</span>' : 
                                                            '<span class="badge badge-pill badge-danger">Inativo</span>'; ?>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-secondary abrirModal" 
                                                            data-id="<?php echo $values['not_id'] ?>" 
                                                            data-titulo="<?php echo $values['not_titulo'] ?>" 
                                                            data-categoria="<?php echo $values['cat_nome'] ?>" 
                                                            data-responsavel="<?php echo $values['usu_nome'] ?>" 
                                                            data-status="<?= ($values['not_status'] == 1) ? 'Ativo' : 'Inativo' ?>">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { 
                                echo 'Nenhuma notícia cadastrada'; 
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAprovacao" tabindex="-1" role="dialog" aria-labelledby="modalAprovacaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAprovacaoLabel">Detalhes da Notícia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="modalTitulo"></span></p>
                <p><strong>Categoria:</strong> <span id="modalCategoria"></span></p>
                <p><strong>Responsável:</strong> <span id="modalResponsavel"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btnAprovar">Aprovar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let idSelecionado = null;

        $(".abrirModal").click(function() {
            idSelecionado = $(this).data("id");
            $("#modalTitulo").text($(this).data("titulo"));
            $("#modalCategoria").text($(this).data("categoria"));
            $("#modalResponsavel").text($(this).data("responsavel"));
            $("#modalStatus").text($(this).data("status"));
            
            $("#modalAprovacao").modal("show");
        });

        $("#btnAprovar").click(function() {
            if (!idSelecionado) {
                Notiflix.Notify.Failure("Nenhum item selecionado.");
                return;
            }

            $.ajax({
                type: "POST",
                url: '/aprovacao-postagens',
                data: { id: idSelecionado },
                success: function(data) {
                    Notiflix.Loading.Remove();
                    if (data.success) {
                        Notiflix.Notify.Success(data.success);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Notiflix.Notify.Failure(data.error);
                    }
                },
                error: function(error) {
                    Notiflix.Notify.Failure("Erro na requisição.");
                    Notiflix.Loading.Remove();
                }
            });
        });
    });
</script>
