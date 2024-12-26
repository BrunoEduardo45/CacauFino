<?php

global $tabela;     $tabela = 'produto';
global $sigla;      $sigla = 'prod';

class ProdutoController extends Actions 
{
    public function Listar(){
        global $tabela;
        loadView('listaProdutos', $tabela,[]);
    } // ok
    public function Cadastrar(){
        global $tabela;
        $dados = $_POST['dados'];
        inserirNoBanco($tabela, $dados);
    } //ok
    public function Editar(){
        global $tabela;
        global $sigla;
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = selecionarDoBanco($tabela, '*', $sigla.'_id = :id', [':id' => $id]);
        if ($dados !== null) {
            header('Content-type: application/json');
            echo json_encode($dados);
        }
    } //ok
    public function Atualizar(){
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = $_POST['dados'];
        $where = $sigla . "_id = " . $id;
        atualizarNoBanco($tabela, $dados, $where);
    } //ok
    public function Deletar(){
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $where = $sigla . "_id = " . $id;
        deletarDoBanco($tabela, $where);
    } //ok
}
