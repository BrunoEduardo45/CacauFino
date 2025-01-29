<?php

    $cat_id = (isset($_GET['cat_id']) ? $_GET['cat_id'] : "");

    // ----------------------------------------------------------------

    if($cat_id){
        $total = selecionarDoBanco('noticias', 'COUNT(*) as total', 'not_status = 1 AND not_categoria = ' . $cat_id);
    } else {
        $total = selecionarDoBanco('noticias', 'COUNT(*) as total', 'not_status = 1');
    }
    
    $total = $total[0]['total'];

    $registros = 9;
    $numPaginas = ceil($total / $registros);
    $inicio = ($registros * $pagina) - $registros;

    if($cat_id){
        $where = 'not_status = 1 AND not_categoria = ' . $cat_id . ' ORDER BY not_id DESC LIMIT '. $inicio .',  '. $registros;
    } else {
        $where = 'not_status = 1 ORDER BY not_id DESC LIMIT '. $inicio .',  '. $registros;
    }

    $join = ['INNER JOIN categoria ON (cat_id = not_categoria)'];

    // ----------------------------------------------------------------

    $noticias = selecionarDoBanco('noticias', '*', $where, [], $join);
    $categorias = selecionarDoBanco('categoria', '*', 'cat_status = 1')

?>

<style>
    .descricao-limitada {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        color:#202122;
    }
</style>

<div class="content-wrapper pb-3">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h1 class="m-0 p-3 rounded" style="background-color: <?php echo $corSecundaria.'20' ?>;">Blog</h1>
                    
                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select class="form-control" id="categoria" name="categoria" required>
                                    <option value="">Todas</option>
                                    <?php foreach ($categorias as $values) { ?>
                                        <option value="<?php echo $values['cat_id'] ?>" <?php echo $cat_id == $values['cat_id'] ? 'selected' : '' ?>><?php echo $values['cat_nome'] ?></option>
                                    <?php } ?>  
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
                <?php foreach ($noticias as $values) { ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="<?php echo $baseUrl . $values['not_url_imagem'] ?>" class="card-img-top" alt="<?php echo $values['not_titulo'] ?>">
                            <div class="card-body">
                                <h3><?php echo $values['not_titulo'] ?></h3>
                                <p class="descricao-limitada"><i><?php echo strip_tags($values['not_descricao']) ?></i></p>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <small class="text-muted"><i class="far fa-calendar-alt mr-1"></i><?php echo date('d/m/Y', strtotime($values['not_data_publicacao'])) ?></small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <small class="text-muted"><i class="fas fa-tags mr-1"></i><?php echo $values['cat_nome'] ?></small>
                                    </div>
                                </div>
                                <a target="_blank" href="noticia/<?php echo $values['not_id'] ?>" class="btn btn-primary btn-block">Saiba mais</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <div class="col-lg-12">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                if ($pagina > 1) {
                    echo "<li class='page-item'><a class='page-link' href='noticias?pagina=" . ($pagina - 1) . "'>Anterior</a></li>";
                }

                for ($i = 1; $i <= $numPaginas; $i++) {
                    $ativo = ($i == $pagina) ? 'class="active"' : '';
                    echo "<li class='page-item' " . $ativo . "><a class='page-link' href='noticias?pagina=$i'>" . $i . "</a></li>";
                }

                if ($pagina < $numPaginas) {
                    echo "<li class='page-item'><a class='page-link' href='noticias?pagina=" . ($pagina + 1) . "'>Próxima</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<script>

    $("#categoria").change(function () {
        var categoria = $(this).val();
        if (!categoria) {
            window.location.href = "noticias"; 
        } else {
            window.location.href = "noticias?cat_id=" + categoria;
        }
    });

</script>

