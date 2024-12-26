<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3 class="col-12">Notícias</h3>
                        <hr>
                        <div class="col-md-12">
                            <?php
                            $joins = [
                                'INNER JOIN categoria ON (cat_id = not_categoria)', 
                                'INNER JOIN usuarios ON (usu_id = not_usuario_id)'
                            ];

                            $list = selecionarDoBanco('noticias', '*', '', [], $joins);
                            $count = count($list);

                            if ($count > 0) { ?>
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-hover w-100">
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
                                                        <a href="<?php echo $baseUrl ?>atualizar-noticias/<?php echo $values['not_id'] ?>" 
                                                           class="btn btn-sm btn-secondary">
                                                            <i class="fas fa-pen-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { echo 'Nenhuma notícia cadastrada'; } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class='btn btn-primary btn-block' href="<?php echo $baseUrl ?>cadastrar-noticia">Cadastrar notícia</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

