<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Comentários para Aprovação</h3>
                        <hr>
                        <?php
                        $list = selecionarDoBanco('comentarios', '*','com_situacao = 2', [], ['inner join usuarios on com_usuario_id = usu_id']);
                        $count = count($list);
                        if ($count > 0) { ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Usuário</th>
                                            <th style="width: 15%">Data</th>
                                            <th style="width: 55%">Texto</th>
                                            <th style="width: 10%">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody class="row_position">
                                        <?php foreach ($list as $values) { ?>
                                            <tr>
                                                <td><?php echo $values['usu_nome'] ?></td>
                                                <td><?php echo $values['com_data'] ?></td>
                                                <td><?php echo $values['com_texto'] ?></td>
                                                <td>
                                                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                        <a href="#" class="btn btn-sm btn-secondary abrirModal" 
                                                            data-id="<?php echo $values['com_id'] ?>" 
                                                            data-usuario="<?php echo $values['usu_nome'] ?>" 
                                                            data-data="<?php echo $values['com_data'] ?>" 
                                                            data-texto="<?php echo $values['com_texto'] ?>">
                                                            <i class="fas fa-search"></i>
                                                        </a>
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

<!-- Modal -->
<div class="modal fade" id="modalAprovacao" tabindex="-1" role="dialog" aria-labelledby="modalAprovacaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAprovacaoLabel">Detalhes do Comentário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Usuário:</strong> <span id="modalUsuario"></span></p>
                <p><strong>Data:</strong> <span id="modalData"></span></p>
                <p><strong>Texto:</strong> <span id="modalTexto"></span></p>
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
            $("#modalUsuario").text($(this).data("usuario"));
            $("#modalData").text($(this).data("data"));
            $("#modalTexto").text($(this).data("texto"));
            
            $("#modalAprovacao").modal("show");
        });

        $("#btnAprovar").click(function() {
            if (!idSelecionado) {
                Notiflix.Notify.Failure("Nenhum item selecionado.");
                return;
            }

            $.ajax({
                type: "POST",
                url: '/aprovacao-comentario',
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
