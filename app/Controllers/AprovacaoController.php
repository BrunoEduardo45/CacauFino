<?php

global $tabela;     $tabela = '';
global $sigla;      $sigla = '';

class AprovacaoController extends Actions 
{
    public function Postagens(){
        loadView('AprovacaoPostagens', 'Aprovacao',[]);
    }

    public function Comentarios(){
        loadView('AprovacaoComentarios', 'Aprovacao',[]);
    }

    public function Cacau(){
        loadView('AprovacaoCacau', 'Aprovacao',[]);
    } 

    public function Produtos(){
        loadView('AprovacaoProdutos', 'Aprovacao',[]);
    }

    public function AprovacaoPostagens(){
        atualizarNoBanco('noticias', ['not_situacao' => 1], 'not_id = '. $_POST['id'] );
    }

    public function AprovacaoComentarios(){
        atualizarNoBanco('comentarios', ['com_situacao' => 1], 'com_id = '. $_POST['id'] );
    }

    public function AprovacaoCacau(){
        atualizarNoBanco('cacau', ['cac_situacao' => 1], 'cac_id = '. $_POST['id'] );
    }

    public function AprovacaoProdutos(){
        atualizarNoBanco('produto', ['prod_situacao' => 1], 'prod_id = '. $_POST['id'] );
    }
}
