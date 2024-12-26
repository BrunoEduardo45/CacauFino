<?php

global $tabela;     $tabela = 'noticias';
global $sigla;      $sigla = 'not';

class NoticiasController extends Actions 
{   
    public function Listar()
    {
        global $tabela;
        loadView('listaNoticias', $tabela,[]);
    } //ok

    public function CadastrarNoticia()
    {
        global $tabela;
        loadView('CadastrarNoticias', $tabela,[]);
    }//ok

    public function AtualizarNoticia($id)
    {
        global $tabela;
        loadView('CadastrarNoticias', $tabela,[
            'id' => $id
        ]);
    } //ok

    public function Cadastrar(){
        global $tabela;
        global $sigla;
        $imagem64    = (isset($_POST['imagem']) ? $_POST['imagem'] : "");
        $dados       = $_POST['dados'];

        try {
            $id = inserirNoBanco($tabela, $dados, false);
            if ($imagem64 != ""){
                $where = $sigla."_id = " . $id;
                $bdNomeImagem = $sigla.'_nome_imagem';
                $bdlUrlImagem = $sigla.'_url_imagem';
                uploadImagem($tabela, $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);
            }
            $data = ['acao' => 'salvo'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            sendTelegramMessage($e);
        }     
    } //ok

    public function Atualizar()
    {
        global $tabela;
        global $sigla; 
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        $dados = $_POST['dados'];
        $imagem64    = (isset($_POST['imagem']) ? $_POST['imagem'] : "");
        
        $where = $sigla."_id = " . $id;
        $bdNomeImagem = $sigla.'_nome_imagem';
        $bdlUrlImagem = $sigla.'_url_imagem';

        try 
        {
            if ($imagem64 != "")
            {
                uploadImagem($tabela, $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);
            }
            
            atualizarNoBanco($tabela, $dados, $where);

            $data = ['acao' => 'salvo'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            sendTelegramMessage($e);
        } 
    } //ok

    public function Deletar()
    {
        $id = (isset($_POST['id']) ? $_POST['id'] : "");
        deletarDoBanco('noticias', 'not_id = ' . $id);
    } //ok

}