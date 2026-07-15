<?php

//Protege o painel: só usuários autenticados podem acessá-lo
if (!isset($_SESSION['auth'])) {
    header('Location: /login');
    exit();
}

//Busca todos os artigos e todos os comentários para exibir no painel administrativo
$artigos = Artigo::all('');
$comentarios = FaleConosco::all();

view('painel', compact('artigos', 'comentarios'));