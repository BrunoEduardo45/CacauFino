<?php

    $noticias = $pdo->prepare("SELECT COUNT(*) FROM noticias WHERE not_status = 1");
    $noticias->execute();
    $totalNoticias = $noticias->fetchColumn();

    $registros = 6;
    $numPaginas = ceil($totalNoticias / $registros);
    $inicio = ($registros * $pagina) - $registros;

    $noticiasPG = $pdo->prepare("SELECT * FROM noticias INNER JOIN categoria ON (cat_id = not_categoria) WHERE not_status = 1 ORDER BY not_id DESC LIMIT :inicio, :registros");
    $noticiasPG->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $noticiasPG->bindParam(':registros', $registros, PDO::PARAM_INT);

    $noticiasPG->execute();
    $list = $noticiasPG->fetchAll(PDO::FETCH_ASSOC);

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
                    <h1 class="m-0 p-3 rounded" style="background-color: <?php echo $corSecundaria.'20' ?>;">Notícias</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
                <?php foreach ($list as $values) { ?>
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

