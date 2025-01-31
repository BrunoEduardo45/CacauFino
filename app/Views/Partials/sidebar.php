<?php

    $totalCacau =       selecionarDoBanco('cacau','count(cac_id)', 'cac_situacao = 2')[0]['count(cac_id)'];
    $totalProdutos =    selecionarDoBanco('produto','count(prod_id)', 'prod_situacao = 2')[0]['count(prod_id)'];
    $totalPostagens =   selecionarDoBanco('noticias','count(not_id)', 'not_situacao = 2')[0]['count(not_id)'];
    $totalComentarios = selecionarDoBanco('comentarios','count(com_id)', 'com_situacao = 2')[0]['count(com_id)'];

    $totalAprovacoes = $totalCacau + $totalProdutos + $totalPostagens + $totalComentarios;

?>

<!-- Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: <?php echo $corSecundaria ?>">
    <div class="sidebar">
        
        <!-- Logo -->
        <div class="d-flex justify-content-center align-items-center">
            <a href="<?php echo $baseUrl ?>" class="brand-link mx-3 mt-3 rounded d-flex justify-content-center" style="background-color:<?php echo $corPrimaria ?>;">
                <?php if ($urlLogo) {
                    echo '<img src="' . $baseUrl . $urlLogo . '" alt="' . $nomeSistema . '" style="max-width: 200px;">';
                } else {
                    echo '<span class="brand-text font-weight-light ml-3">' . $nomeSistema . '</span>';
                } ?>
            </a>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu">

            <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

            <!-- Menu Cliente -->
            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Home</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>produtos" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Produtos</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>cacaus" class="nav-link">
                    <i class="nav-icon fas fa-tree"></i>
                    <p>Cacau</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>cacaufino" class="nav-link">
                    <i class="nav-icon fas fa-info"></i>
                    <p>Cacau Fino</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>noticias" class="nav-link">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <p>Blog</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>contato" class="nav-link">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Contato</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>sobre" class="nav-link">
                    <i class="nav-icon fas fa-info-circle"></i>
                    <p>Sobre</p>
                </a>
            </li>
            
            <?php if($IdUser){ ?>

                <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">
                
                <?php if($tipo == 1){ ?>

                    <li class="nav-item">
                        <a href="<?php echo $baseUrl ?>dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                            Dashboard
                            </p>
                        </a>
                    </li>

                <?php } ?>

                <?php if($tipo == 1 || $comprador == 1 || $vendedor == 1){ ?>
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
                                    <p>Cacau</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>lista-produtos" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Produtos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>lista-noticias" class="nav-link">
                                    <i class="nav-icon far fa-newspaper"></i>
                                    <p>Postagens</p>
                                </a>
                            </li>
                            <?php if($tipo == 1){ ?>
                                <li class="nav-item">
                                    <a href="<?php echo $baseUrl ?>lista-categorias" class="nav-link">
                                        <i class="nav-icon fas fa-tags"></i>
                                        <p>Categorias</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if($tipo == 1){ ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Aprovações <i class="fas fa-angle-left right"></i>
                                <?php if($totalAprovacoes > 0) { ?><span class="badge badge-danger right"><?php echo $totalAprovacoes; ?></span><?php } ?>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>tela-postagens" class="nav-link">
                                <i class="nav-icon fa-sm mr-2 far fa-dot-circle"></i>
                                    <p>Postagens 
                                        <?php if($totalPostagens > 0) { ?><span class="badge badge-danger right"><?php echo $totalPostagens; ?></span><?php } ?>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>tela-comentarios" class="nav-link">
                                <i class="nav-icon fa-sm mr-2 far fa-dot-circle"></i>
                                    <p>Comentários 
                                        <?php if($totalComentarios > 0) { ?><span class="badge badge-danger right"><?php echo $totalComentarios; ?></span><?php } ?>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>tela-cacau" class="nav-link">
                                <i class="nav-icon fa-sm mr-2 far fa-dot-circle"></i>
                                    <p>Cacau 
                                        <?php if($totalCacau > 0) { ?><span class="badge badge-danger right"><?php echo $totalCacau; ?></span><?php } ?>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $baseUrl ?>tela-produtos" class="nav-link">
                                <i class="nav-icon fa-sm mr-2 far fa-dot-circle"></i>
                                    <p>Produtos 
                                        <?php if($totalProdutos > 0) { ?><span class="badge badge-danger right"><?php echo $totalProdutos; ?></span><?php } ?>
                                        </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo $baseUrl ?>configuracao" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Configuração</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo $baseUrl ?>lista-usuarios" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Usuários</p>
                        </a>
                    </li>

                <?php } ?>

            <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>usuario" class="nav-link">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>Perfil</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo $baseUrl ?>logout/<?php echo $IdUser ?>" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Sair</p>
                </a>
            </li>

            <?php } ?>

            <hr style="border-top: 1px solid <?php echo $corPrimaria.'30' ?>; margin: 1rem 0;">

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>

</aside>
