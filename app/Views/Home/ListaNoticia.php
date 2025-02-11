<?php

    $tipo = isset($args['tipo']) ? $args['tipo'] : "";

    $cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : "";
    $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) && $_GET['pagina'] > 0 ? intval($_GET['pagina']) : 1;

    if ($cat_id) {
        $total = selecionarDoBanco('noticias', 'COUNT(*) as total', 'not_tipo = ' . $tipo . ' AND not_status = 1 AND not_situacao = 1 AND not_categoria = ' . $cat_id);
    } else {
        $total = selecionarDoBanco('noticias', 'COUNT(*) as total', 'not_tipo = ' . $tipo . ' AND not_status = 1 AND not_situacao = 1');
    }

    $total = $total[0]['total'];
    $registros = 9;
    $numPaginas = ceil($total / $registros);
    $inicio = ($registros * $pagina) - $registros;

    $where = $cat_id
        ? 'not_tipo = ' . $tipo . ' AND not_status = 1 AND not_categoria = ' . $cat_id . ' ORDER BY not_id DESC LIMIT ' . $inicio . ', ' . $registros
        : 'not_tipo = ' . $tipo . ' AND not_status = 1 ORDER BY not_id DESC LIMIT ' . $inicio . ', ' . $registros;

    $join = ['INNER JOIN categoria ON (cat_id = not_categoria)'];
    $noticias = selecionarDoBanco('noticias', '*', $where, [], $join);
    $categorias = selecionarDoBanco('categoria', '*', 'cat_status = 1');
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<style>
    .descricao-limitada {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #202122;
    }

    .pagination .page-item .page-link {
        color: <?php echo $corSecundaria ?>;
    }

    .pagination .page-item .page-link:hover {
        background-color: <?php echo $corSecundaria . '30' ?>;
    }

    .pagination .page-item.active .page-link {
        background-color: <?php echo $corPrimaria ?>;
        border-color: <?php echo $corPrimaria ?>;
    }
</style>

<main class="main">
    <section id="blog-posts-2" class="blog-posts-2 section pt-3">
        <div class="container">
            <div class="row mb-4 mt-2">
                <div class="col-lg-3 offset-lg-9">
                    <div class="form-group">
                        <select class="form-control" id="categoria" name="categoria">
                            <option value="">Todas</option>
                            <?php foreach ($categorias as $values) { ?>
                                <option value="<?php echo $values['cat_id'] ?>" <?php echo $cat_id == $values['cat_id'] ? 'selected' : '' ?>><?php echo $values['cat_nome'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <?php foreach ($noticias as $values) { ?>
                    <div class="col-lg-4">
                        <article class="position-relative h-100">
                            <div class="post-img position-relative overflow-hidden">
                                <img src="<?php echo $baseUrl . $values['not_url_imagem'] ?>" class="img-fluid" alt="<?php echo $values['not_titulo'] ?>">
                            </div>
                            <div class="d-flex align-items-end justify-content-between p-2">
                                <span style="background-color: <?php echo $corPrimaria ?>; padding: 3px 6px; border-radius: 4px;">
                                    <span style="color: <?php echo $corSecundaria ?>; font-weight: bold;">
                                        <?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?>
                                    </span>
                                </span>
                                <div class="">
                                    <span style="color: <?php echo $corSecundaria ?>; font-weight: bold;">
                                        <?php echo $values['cat_nome'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="post-content d-flex flex-column p-3 m-0">
                                <h3 class="post-title"><?php echo $values['not_titulo'] ?></h3>
                                <p class="descricao-limitada"><i><?php echo strip_tags($values['not_descricao']) ?></i></p>
                                <a href="noticia?id=<?php echo $values['not_id'] ?>" class="readmore stretched-link">
                                    <span>Leia Mais</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section id="blog-pagination" class="blog-pagination section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    <?php if ($pagina > 1) { ?>
                        <li class="page-item"><a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $pagina - 1; ?>">&laquo; Anterior</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $numPaginas; $i++) { ?>
                        <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                            <a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($pagina < $numPaginas) { ?>
                        <li class="page-item"><a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $pagina + 1; ?>">Próxima &raquo;</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        $("#categoria").select2({
            placeholder: "Selecione uma categoria",
            allowClear: true
        });
    });

    $("#categoria").change(function () {
        var categoria = $(this).val();
        var tipo = <?php echo json_encode($tipo); ?>;

        if(tipo == 1) { 
            var pagina = 'noticias';
        } else if (tipo == 2) { 
            var pagina = 'eventos';
        } else {
            var pagina = 'blog';
        }

        if (!categoria) {
            window.location.href = pagina;
        } else {
            window.location.href = pagina + "?&cat_id=" + categoria;
        }
    });
</script>
