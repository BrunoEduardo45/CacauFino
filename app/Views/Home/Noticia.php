<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h1 class="m-0 p-3 rounded" style="background-color: <?php echo $corSecundaria.'20' ?>;">Notícia</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
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
                                <h3><?php echo $values['not_titulo'] ?></h3>
                                <p class="card-text text-justify"><?php echo $values['not_descricao'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <p><i class="far fa-calendar-alt mr-2"></i> Publicado em: <?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?></p>
                                <p><i class="fas fa-tags mr-2"></i> Categoria: <?php echo $values['cat_nome'] ?></p>
                                <p><i class="fas fa-user-circle mr-2"></i> Criado por: <?php echo $values['usu_nome'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
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
