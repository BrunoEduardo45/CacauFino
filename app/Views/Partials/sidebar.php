<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: <?php echo $corSecundaria ?>">
  <!-- Brand Logo -->

  <div class="d-flex justify-content-center align-items-center">
    <a href="<?php echo $baseUrl ?>" class="brand-link mx-3 mt-3 rounded d-flex justify-content-center" style="background-color:<?php echo $corPrimaria ?>;">
      <?php if ($urlLogo) {
        echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" style="max-width: 200px;">';
      } else {
        echo '<span class="brand-text font-weight-light ml-3">' . $nomeSistema . '</span>';
      } ?>
    </a>
  </div>

  <div class="sidebar">

  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu">

      <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

      <!-- Menu Cliente -->
      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>" class="nav-link">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Home
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>produtos" class="nav-link">
          <i class="nav-icon fas fa-shopping-bag"></i>
          <p>
            Produtos
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>cacaus" class="nav-link">
          <i class="nav-icon fas fa-tree"></i>
          <p>
            Cacau
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>noticias" class="nav-link">
          <i class="nav-icon fas fa-newspaper"></i>
          <p>
            Notícias
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>contato" class="nav-link">
          <i class="nav-icon fas fa-envelope"></i>
          <p>
            Contato
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>sobre" class="nav-link">
          <i class="nav-icon fas fa-info-circle"></i>
          <p>
            Sobre
          </p>
        </a>
      </li>

      <!-- Se tiver logado -->
      <?php if($IdUser){ ?>

      <!-- se for adm -->
      <?php if($tipo == 1){ ?>

        <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

        <!-- Menu Administrativo -->
        <li class="nav-item">
          <a href="<?php echo $baseUrl ?>dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Cadastro
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo $baseUrl ?>lista-cacau" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Cacau
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $baseUrl ?>lista-produtos" class="nav-link">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                  Produtos
                </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>
              Conteúdo
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo $baseUrl ?>lista-noticias" class="nav-link">
                <i class="nav-icon far fa-newspaper"></i>
                <p>
                  Notícias
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $baseUrl ?>lista-categorias" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>
                  Categoria
                </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?php echo $baseUrl ?>configuracao" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Configuração
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $baseUrl ?>lista-usuarios" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Usuários
            </p>
          </a>
        </li>

      <?php } ?>

      <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>usuario" class="nav-link">
          <i class="nav-icon fas fa-user-circle"></i>
          <p>
            Perfil
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="<?php echo $baseUrl ?>logout/<?php echo $IdUser ?>" class="nav-link">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>
            Sair
          </p>
        </a>
      </li>

      <?php } ?>

      <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>

</aside>
