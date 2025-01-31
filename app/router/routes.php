<?php

$routes = [

    // CLIENTE //
    
        '/' =>               'HomeController@Home', //ok
        '/contato' =>        'HomeController@Contato', //ok
        '/sobre' =>          'HomeController@Sobre', //ok
        '/noticias' =>       'HomeController@Noticias', //ok
        '/noticia/{id}' =>   'HomeController@Noticia', //ok
        '/produtos' =>       'HomeController@Produtos', //ok
        '/cacaus' =>         'HomeController@Cacaus', //ok
        '/cacaufino' =>      'HomeController@CacauFino', //ok

    // ADMINISTRATIVO //

        '/dashboard' =>                 'HomeController@Dashboard', //ok

        // Configuração
        '/configuracao' =>              'ConfiguracaoController@index', //ok
        '/atualizar-configuracao' =>    'ConfiguracaoController@Atualizar', //ok
        '/atualizarimg-configuracao' => 'ConfiguracaoController@AtualizarImagem', //ok

        // Aprovação 
        '/tela-postagens' =>        'AprovacaoController@Postagens', //ok
        '/tela-comentarios' =>      'AprovacaoController@Comentarios', //ok
        '/tela-cacau' =>            'AprovacaoController@Cacau', //ok
        '/tela-produtos' =>         'AprovacaoController@Produtos', //ok
        '/aprovacao-postagens' =>   'AprovacaoController@AprovacaoPostagens', //ok
        '/aprovacao-comentario' => 'AprovacaoController@AprovacaoComentarios', //ok
        '/aprovacao-cacau' =>       'AprovacaoController@AprovacaoCacau', //ok
        '/aprovacao-produto' =>    'AprovacaoController@AprovacaoProdutos', //ok

        // Cacau
        '/lista-cacau' =>          'CacauController@Listar', //ok
        '/cadastrar-cacau' =>      'CacauController@Cadastrar', //ok
        '/editar-cacau' =>         'CacauController@Editar', //ok
        '/atualizar-cacau' =>      'CacauController@Atualizar', //ok
        '/deletar-cacau' =>        'CacauController@Deletar', //ok

        // Produto
        '/lista-produtos' =>          'ProdutoController@Listar', //ok
        '/cadastrar-produtos' =>      'ProdutoController@Cadastrar', //ok
        '/editar-produtos' =>         'ProdutoController@Editar', //ok
        '/atualizar-produtos' =>      'ProdutoController@Atualizar', //ok
        '/deletar-produtos' =>        'ProdutoController@Deletar', //ok

        // Categoria
        '/lista-categorias' =>          'CategoriaController@Listar', //ok
        '/cadastrar-categorias' =>      'CategoriaController@Cadastrar', //ok
        '/editar-categorias' =>         'CategoriaController@Editar', //ok
        '/atualizar-categorias' =>      'CategoriaController@Atualizar', //ok
        '/deletar-categorias' =>        'CategoriaController@Deletar', //ok

        // Noticias
        '/lista-noticias' =>            'NoticiasController@Listar', //ok
        '/cadastrar-noticia' =>         'NoticiasController@CadastrarNoticia', //ok
        '/atualizar-noticias/{id}' =>   'NoticiasController@AtualizarNoticia', //ok
        '/inserir-noticia' =>           'NoticiasController@Cadastrar', //ok
        '/atualizacao-noticia' =>       'NoticiasController@Atualizar', //ok
        '/deletar-noticia' =>           'NoticiasController@Deletar', //ok

        // Comentários 
        '/inserir-comentario' =>           'ComentariosController@Inserir', //ok
        '/deletar-comentario' =>           'ComentariosController@Deletar', //ok

        // Usuario
        '/login-page' =>                'UsuarioController@LoginPage', //ok
        '/registro' =>                  'UsuarioController@Registro',//ok
        '/usuario' =>                   'UsuarioController@Perfil',//ok
        '/cadastrar-usuario' =>         'UsuarioController@CadastrarUsuario',//ok
        '/atualizar-usuario' =>         'UsuarioController@AtualizarUsuario',//ok
        '/resetar-senha' =>             'UsuarioController@Resetar',//ok
        '/resetar' =>                   'UsuarioController@ResetarSenha',
        '/login' =>                     'UsuarioController@Login',//ok
        '/logout/{id}' =>               'UsuarioController@Logout',//ok
        '/imagem-perfil' =>             'UsuarioController@imagemPerfil',//ok
        '/lista-usuarios' =>            'UsuarioController@Listar', //ok
        '/inserir-usuario' =>           'UsuarioController@InserirUsuario', //ok
        '/deletar-usuario' =>           'UsuarioController@DeletarUsuario',
        '/update-adm' =>                'UsuarioController@UpdateAdm', //ok
        '/visualizar' =>                'UsuarioController@Visualizar',//ok
        '/verificar' =>                 'UsuarioController@Verificar',//ok
];