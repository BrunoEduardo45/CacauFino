    <section class="py-4 px-0">
            <div class="row">
                <?php
                    $join = [
                        "INNER JOIN categoria ON (cat_id = not_categoria)",
                        "INNER JOIN usuarios ON (usu_id = not_usuario_id)",
                    ];
                    $result = selecionarDoBanco('noticias', 'not_titulo, not_descricao, not_url_imagem, not_data_publicacao, cat_nome, usu_nome', 'not_status = 1 and not_id = :id', [':id' => $IDNoticia], $join);
                    foreach ($result as $values) { 
                ?>
                    <div class="col-lg-8">
                        <div class="card">
                            <img src="<?php echo $baseUrl . $values['not_url_imagem'] ?>" class="card-img-top" alt="<?php echo $values['not_titulo'] ?>">
                            <div class="card-body">
                                <h3><b><?php echo $values['not_titulo'] ?></b></h3>
                                <p class="card-text text-justify"><?php echo $values['not_descricao'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <p><i class="far fa-calendar-alt mr-2"></i> <b>Publicado em: </b><?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?></p>
                                <p><i class="fas fa-tags mr-2"></i> <b>Categoria: </b><?php echo $values['cat_nome'] ?></p>
                                <p><i class="fas fa-user-circle mr-2"></i> <b>Criado por: </b><?php echo $values['usu_nome'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Sessão de Comentários -->
            <div class="row mt-5 mb-3">
                <div class="col-lg-8">
                    <h4>Comentários</h4>
                    <div id="comentarios">
                        <?php
                            $comentarios = selecionarDoBanco('comentarios', '*', 'com_noticia_id = :id and com_situacao = 1', [':id' => $IDNoticia], ['LEFT JOIN usuarios ON com_usuario_id = usu_id']);
                            foreach ($comentarios as $comentario) {
                        ?>
                            <div class="card mb-2 shadow-sm" id="comentario-<?php echo $comentario['com_id']; ?>">
                                <div class=" p-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong><?php echo htmlspecialchars($comentario['usu_nome']); ?></strong> <span class="text-muted small">em <?php echo date('d/m/Y H:i', strtotime($comentario['com_data'])); ?></span></p>
                                        <p class="mb-0 text-muted"><?php echo nl2br(htmlspecialchars($comentario['com_texto'])); ?></p>
                                    </div>
                                    <?php if ($comentario['com_usuario_id'] == $IdUser) { ?>
                                        <button class="btn btn-outline-danger delete-comentario" data-id="<?php echo $comentario['com_id']; ?>" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Formulário de Comentários -->
                    <div class="card mt-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">Deixe um comentário</h5>
                            <form id="form-comentario">
                                <div class="form-group">
                                    <label for="comentario" class="form-label">Comentário</label>
                                    <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                                </div>
                                <input type="hidden" name="noticia_id" id="noticia_id" value="<?php echo $IDNoticia; ?>">
                                <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $IdUser; ?>">
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Publicar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
  </section>

<script>
    $(document).ready(function() {
        $('#form-comentario').submit(function(e) {
            e.preventDefault();
            var dados = {
                'com_texto': $("#comentario").val(),
                'com_noticia_id': $("#noticia_id").val(),
                'com_usuario_id': $("#usuario_id").val(),
                'com_situacao': 2,
            };
            Notiflix.Loading.Pulse('Carregando...');
            debugger;
            $.ajax({
                type: "POST",
                url: "/inserir-comentario",
                data: {dados: dados},
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
                    if (error.success != "") {
                        Notiflix.Loading.Remove();
                        Notiflix.Notify.Success(error.success);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Notiflix.Notify.Failure(error.msg);
                        Notiflix.Loading.Remove();
                        console.error("Erro na requisição AJAX:", error);
                    }
                }
            });
        });

        $('.delete-comentario').click(function() {
            var comId = $(this).data('id');
            
            Notiflix.Confirm.Show(
                'Excluir Comentário',
                'Tem certeza que deseja excluir este comentário?',
                'Sim', 'Não',
                function okCb() {
                    Notiflix.Loading.Pulse('Carregando...');
                    $.ajax({
                        type: "POST",
                        url: "/deletar-comentario",
                        data: { 'com_id': comId },
                        success: function(response) {
                            Notiflix.Loading.Remove();
                            if (response.success) {
                                Notiflix.Notify.Success(response.success);
                                $('#comentario-' + comId).remove();
                            } else {
                                Notiflix.Notify.Failure(response.error);
                            }
                        },
                        error: function(error) {
                            Notiflix.Loading.Remove();
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });
                },
                function cancelCb() {},
            );
        });

        $('.publicidade-link').click(function(e) {
            var pubId = $(this).data('id');
            
            $.ajax({
                type: "POST",
                url: "/click",
                data: { id: pubId },
                success: function(data) {
                    console.log("Clique registrado com sucesso.");
                },
                error: function(error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        });
    });  
</script>


