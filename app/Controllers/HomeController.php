<?php

global $tabela;     $tabela = 'Home';
global $pagina;     $pagina = 'dashboard';

class HomeController extends Actions {
    
/// ADMINISTRATIVO ///
    
    public function Dashboard(){
        global $tabela;
        loadView('Dashboard', $tabela,[]);
    } 

/// CLIENTE ///

    public function Home(){
        global $tabela;
        loadView('Home', $tabela,[]);
    } 

    public function Contato(){
        global $tabela;
        loadView('Contato', $tabela,[]);
    } 

    public function Sobre(){
        global $tabela;
        loadView('Sobre', $tabela,[]);
    } 

    public function Produtos(){
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('ListaProdutos', $tabela,[
            'pagina' => $pagina,
        ]);
    } 

    public function Cacaus(){
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('ListaCacau', $tabela,[
            'pagina' => $pagina,
        ]);
    } 

    public function Noticias()
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('ListaNoticia', $tabela,[
            'pagina' => $pagina,
        ]);
    }

    public function Noticia($id)
    {
        global $tabela;
        loadView('noticia', $tabela,[
            'IDNoticia' => $id[0],
        ]);
    }
}