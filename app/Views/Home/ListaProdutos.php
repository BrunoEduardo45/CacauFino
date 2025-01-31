<?php
    // Consultar o total de produtos disponíveis
    $produtos = $pdo->prepare("SELECT COUNT(*) FROM produto WHERE prod_status = 1");
    $produtos->execute();
    $totalProdutos = $produtos->fetchColumn();

    // Configuração da paginação
    $registros = 6; // Número de registros por página
    $numPaginas = ceil($totalProdutos / $registros);
    $inicio = ($registros * $pagina) - $registros;

    // Buscar os produtos para a página atual
    $produtosPG = $pdo->prepare("
        SELECT * 
        FROM produto 
        WHERE prod_status = 1 and prod_situacao = 1
        ORDER BY prod_id DESC 
        LIMIT :inicio, :registros
    ");
    $produtosPG->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $produtosPG->bindParam(':registros', $registros, PDO::PARAM_INT);

    $produtosPG->execute();
    $list = $produtosPG->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper pb-3">

    <!-- Cabeçalho -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <h1 class="m-0 p-3 rounded" style="background-color: <?php echo $corSecundaria.'20' ?>;">Listas de Produtos</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Produtos -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
                <?php foreach ($list as $values) { ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="<?php echo $baseUrl ?>/app/public/img/Produtos.png" class="card-img-top" alt="<?php echo $values['prod_titulo']; ?>">
                            <div class="card-body">
                                <h3><?php echo $values['prod_titulo']; ?></h3>
                                <p class="descricao-limitada"><i><?php echo strip_tags($values['prod_descricao']); ?></i></p>
                                <p><strong>Preço:</strong> R$ <?php echo number_format($values['prod_preco'], 2, ',', '.'); ?></p>
                                <p><strong>Estoque:</strong> <?php echo $values['prod_quantidade'] . ' ' . $values['prod_unidade']; ?></p>
                                
                                <!-- Botão para abrir a modal -->
                                <button class="btn btn-link text-primary p-0 mb-3 text-center w-100" data-toggle="modal" data-target="#detalhesModal" 
                                        data-id="<?php echo $values['prod_id']; ?>"
                                        data-titulo="<?php echo $values['prod_titulo']; ?>"
                                        data-descricao="<?php echo strip_tags($values['prod_descricao']); ?>"
                                        data-preco="<?php echo number_format($values['prod_preco'], 2, ',', '.'); ?>"
                                        data-quantidade="<?php echo $values['prod_quantidade'] . ' ' . $values['prod_unidade']; ?>">
                                    Ver mais detalhes
                                </button>
                                
                                <!-- Formulário para adicionar ao carrinho -->
                                <form action="adicionar-carrinho.php" method="POST">
                                    <input type="hidden" name="produto_id" value="<?php echo $values['prod_id']; ?>">
                                    <div class="form-group">
                                        <label for="quantidade_<?php echo $values['prod_id']; ?>">Quantidade</label>
                                        <input type="number" id="quantidade_<?php echo $values['prod_id']; ?>" name="quantidade" class="form-control" min="1" max="<?php echo $values['prod_quantidade']; ?>" value="1" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus mr-2"></i> Adicionar ao Carrinho</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Paginação -->
    <div class="col-lg-12">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                if ($pagina > 1) {
                    echo "<li class='page-item'><a class='page-link' href='produtos?pagina=" . ($pagina - 1) . "'>Anterior</a></li>";
                }

                for ($i = 1; $i <= $numPaginas; $i++) {
                    $ativo = ($i == $pagina) ? 'class="active"' : '';
                    echo "<li class='page-item' " . $ativo . "><a class='page-link' href='produtos?pagina=$i'>" . $i . "</a></li>";
                }

                if ($pagina < $numPaginas) {
                    echo "<li class='page-item'><a class='page-link' href='produtos?pagina=" . ($pagina + 1) . "'>Próxima</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detalhesModal" tabindex="-1" role="dialog" aria-labelledby="detalhesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalhesModalLabel">Detalhes do Produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <img id="modalImagem" src="<?php echo $baseUrl ?>/app/public/img/Cacau.png" alt="Produto" class="img-fluid">
          </div>
          <div class="col-md-6">
            <h4 id="modalTitulo"></h4>
            <p id="modalDescricao"></p>
            <p><strong>Preço:</strong> R$ <span id="modalPreco"></span></p>
            <p><strong>Estoque disponível:</strong> <span id="modalQuantidade"></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Script para preencher os dados da modal dinamicamente
  $('#detalhesModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botão que acionou a modal
    var titulo = button.data('titulo');
    var descricao = button.data('descricao');
    var preco = button.data('preco');
    var quantidade = button.data('quantidade');

    var modal = $(this);
    modal.find('#modalTitulo').text(titulo);
    modal.find('#modalDescricao').text(descricao);
    modal.find('#modalPreco').text(preco);
    modal.find('#modalQuantidade').text(quantidade);
  });
</script>
