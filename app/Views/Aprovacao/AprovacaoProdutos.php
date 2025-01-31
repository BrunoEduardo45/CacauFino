<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">    
            <div class="col-md-12">       
                <div class="card card-outline card-primary">
                    <div class="card-body">                            
                        <h3>Produtos para Aprovação</h3>
                        <hr>
                        <?php
                        $list = selecionarDoBanco('produto', '*', 'prod_situacao = 2');
                        $count = count($list);
                        if ($count > 0) { ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover table-sm w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 40%">Título</th>
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
                                                        <a href="#" class="btn btn-sm btn-secondary abrirModal" 
                                                            data-id="<?php echo $values['prod_id'] ?>" 
                                                            data-titulo="<?php echo $values['prod_titulo'] ?>" 
                                                            data-valor="<?php echo 'R$' . $values['prod_preco'] ?>" 
                                                            data-qtd="<?php echo $values['prod_quantidade'] . ' ' . $values['prod_unidade'] ?>"
                                                            data-status="<?= ($values['prod_status'] == 1) ? 'Ativo' : 'Inativo' ?>">
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
                <h5 class="modal-title" id="modalAprovacaoLabel">Detalhes do Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Título:</strong> <span id="modalTitulo"></span></p>
                <p><strong>Valor:</strong> <span id="modalValor"></span></p>
                <p><strong>Quantidade:</strong> <span id="modalQtd"></span></p>
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
            $("#modalValor").text($(this).data("valor"));
            $("#modalQtd").text($(this).data("qtd"));
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
                url: '/aprovacao-produto',
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