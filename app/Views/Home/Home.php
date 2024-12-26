<div class="content-wrapper">
  <section class="content">

    <div class="container-fluid p-3">

      <!-- Banner Principal -->
      <div class="banner-wrapper position-relative mb-5">
        <img src="<?php echo $baseUrl ?>/app/public/img/Banner.webp" alt="Banner Promocional" class="img-fluid w-100">
        <div class="banner-content text-center mt-3">
          <h1 class="display-4 fw-bold">Bem-vindo à nossa loja de Cacau Fino!</h1>
          <p class="lead">Descubra a excelência dos nossos produtos e aproveite nossas promoções exclusivas.</p>
        </div>
      </div>

      <!-- Destaques da Empresa -->
      <div class="row mb-5 text-center py-4 bg-light">
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-seedling fa-3x mb-3 text-success"></i>
            <h3 class="fw-bold">Qualidade Superior</h3>
            <p class="text-muted">Produtos selecionados com rigor para garantir o melhor sabor e frescor.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-globe-americas fa-3x mb-3 text-primary"></i>
            <h3 class="fw-bold">Origem Sustentável</h3>
            <p class="text-muted">Trabalhamos com práticas responsáveis e valorizamos os produtores locais.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <i class="fas fa-truck fa-3x mb-3 text-warning"></i>
            <h3 class="fw-bold">Entrega Rápida</h3>
            <p class="text-muted">Receba seus produtos com segurança e agilidade em todo o Brasil.</p>
          </div>
        </div>
      </div>

      <!-- Seção de Cacaus em Destaque -->
        <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Cacaus em Destaque</h3>
                    <hr>
                </div>
        </div>
        <div class="row">
            <?php
            // Consultar cacaus em destaque
            $cacausDestaque = $pdo->prepare("
                SELECT * 
                FROM cacau 
                WHERE cac_status = 1 
                ORDER BY RAND() 
                LIMIT 3
            ");
            $cacausDestaque->execute();
            $cacaus = $cacausDestaque->fetchAll(PDO::FETCH_ASSOC);

            foreach ($cacaus as $cacau) { ?>
            <div class="col-md-4">
                <div class="card">
                <img src="<?php echo $baseUrl ?>/app/public/img/Cacau.png" class="card-img-top" alt="<?php echo $cacau['cac_titulo']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $cacau['cac_titulo']; ?></h5>
                    <p class="card-text">R$ <?php echo number_format($cacau['cac_preco'], 2, ',', '.'); ?></p>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
            <a href="/cacaus" class="btn btn-secondary">Ver Todos</a>
            </div>
        </div>

        <!-- Seção de Produtos em Destaque -->
        <div class="row mt-5">
            <div class="col-md-12">
            <h3 class="text-center">Produtos em Destaque</h3>
            <hr>
            </div>
        </div>
        <div class="row">
            <?php
            // Consultar produtos em destaque
            $produtosDestaque = $pdo->prepare("
                SELECT * 
                FROM produto 
                WHERE prod_status = 1 
                ORDER BY RAND() 
                LIMIT 3
            ");
            $produtosDestaque->execute();
            $produtos = $produtosDestaque->fetchAll(PDO::FETCH_ASSOC);

            foreach ($produtos as $produto) { ?>
            <div class="col-md-4">
                <div class="card">
                <img src="<?php echo $baseUrl ?>/app/public/img/Produtos.png" class="card-img-top" alt="<?php echo $produto['prod_titulo']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $produto['prod_titulo']; ?></h5>
                    <p class="card-text">R$ <?php echo number_format($produto['prod_preco'], 2, ',', '.'); ?></p>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
            <a href="/produtos" class="btn btn-secondary">Ver Todos</a>
            </div>
        </div>

        </div>

        <!-- Contato -->
        <div class="contact-section py-5" style="background-color: <?php echo $corSecundaria.'20' ?>;">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12">
                        <h3 class="fw-bold">Entre em Contato</h3>
                        <p class="lead">Fale conosco para tirar dúvidas, fazer sugestões ou encomendar nossos produtos.</p>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-md-4 text-center">
                        <a href="/contato" class="btn btn-light btn-lg w-100 mb-3">Fale Conosco</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

  </section>
</div>
