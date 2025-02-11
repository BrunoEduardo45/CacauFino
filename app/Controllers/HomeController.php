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

    public function Cotacoes(){
        global $tabela;
        loadView('Cotacoes', $tabela,[]);
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

    public function CacauFino(){
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        loadView('CacauFino', $tabela,[
            'pagina' => $pagina,
        ]);
    } 

    public function Noticias()
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        $tipo = 1;

        loadView('ListaNoticia', $tabela,[
            'pagina' => $pagina,
            'tipo' => $tipo,
        ]);
    }
    
    public function Eventos()
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        $tipo = 2;

        loadView('ListaNoticia', $tabela,[
            'pagina' => $pagina,
            'tipo' => $tipo,
        ]);
    }

    public function Blog()
    {
        global $tabela;
        $pagina = $_GET['pagina'] ?? 1;
        $tipo = 3;
        
        loadView('ListaNoticia', $tabela,[
            'pagina' => $pagina,
            'tipo' => $tipo,
        ]);
    }

    public function Noticia()
    {
        global $tabela;
        $id = $_GET['id'];
        loadView('Noticia', $tabela,[
            'IDNoticia' => $id,
        ]);
    }
}