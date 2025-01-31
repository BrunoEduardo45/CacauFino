<?php

global $tabela;     $tabela = 'comentarios';
global $sigla;      $sigla = 'com';

class ComentariosController extends Actions 
{
    public function Inserir(){
        global $tabela;
        $dados = $_POST['dados'];
        $dados['com_texto'] = addslashes($dados['com_texto']);
        inserirNoBanco($tabela, $dados);
    } //ok

    public function Deletar(){
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $where = $sigla . "_id = " . $id;
        deletarDoBanco($tabela, $where);
    } //ok
}
