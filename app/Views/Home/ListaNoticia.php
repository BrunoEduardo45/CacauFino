<?php

    $tipo = isset($args['tipo']) ? $args['tipo'] : "";

    $titulo = "";

    if ($tipo == 1) {
        $titulo = "Todas as notícias";
    } else if ($tipo == 2) {
        $titulo = "Todos os eventos";
    } else if ($tipo == 3) {
        $titulo = "Blog";
    }

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
   .card-cotacao {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        transition: transform 0.2s;
        background-color: #fff;
    }

    .card-cotacao:hover {
        transform: scale(1.02);
    }

    .card-cotacao a {
        text-decoration: none;
        color: inherit;
    }

    .card-cotacao .post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px 5px 0 0;
    }

    .card-cotacao .p-3 {
        padding: 15px;
    }

    .card-cotacao .titulo {
        font-weight: bold;
        font-size: 1.2em;
    }

    .card-cotacao .descricao-limitada {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .anuncio {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background-color: #f9f9f9;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="pt-3">
    <div class="container">
        <h2 class="mb-4 mt-2"><?php echo htmlspecialchars($titulo); ?></h2>
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="form-group mb-3">
                    <select class="form-control" id="categoria" name="categoria">
                        <option value="">Todas</option>
                        <?php foreach ($categorias as $values) { ?>
                            <option value="<?php echo $values['cat_id'] ?>" <?php echo $cat_id == $values['cat_id'] ? 'selected' : '' ?>>
                                <?php echo $values['cat_nome'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <?php foreach ($noticias as $values) { ?>
                    <div class="col-lg-12 mb-2">
                    <a href="noticia?id=<?php echo $values['not_id'] ?>" class="card-cotacao h-100 d-block">
                        <div class="row no-gutters h-100">
                            <div class="col-md-4 post-img">
                                <img src="<?php echo $baseUrl . $values['not_url_imagem']; ?>" class="img-fluid" alt="<?php echo $values['not_titulo']; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="p-3">
                                <h5 class="titulo"><?php echo $values['not_titulo']; ?></h5>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?>
                                </small>
                                <p class="descricao-limitada">
                                    <?php echo strip_tags($values['not_descricao']); ?>
                                </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-4">
                
                <div class="h-100">
                    <div class="anuncio rounded bg-light p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 1">
                    </div>
                    <div class="anuncio rounded bg-light mt-3 p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 2">
                    </div>
                    <div class="anuncio rounded bg-light mt-3 p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="blog-pagination">
    <div class="container">
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <?php if ($pagina > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $pagina - 1; ?>">
                            &laquo; Anterior
                        </a>
                    </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $numPaginas; $i++) { ?>
                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                        <a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($pagina < $numPaginas) { ?>
                    <li class="page-item">
                        <a class="page-link" href="noticias?tipo=<?php echo $tipo; ?>&pagina=<?php echo $pagina + 1; ?>">
                            Próxima &raquo;
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

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

        var pagina = tipo == 1 ? 'noticias' : tipo == 2 ? 'eventos' : 'blog';

        if (!categoria) {
            window.location.href = pagina;
        } else {
            window.location.href = pagina + "?&cat_id=" + categoria;
        }
    });
</script>
