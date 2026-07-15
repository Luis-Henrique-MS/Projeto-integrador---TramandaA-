<?php

//Pega o ID do ponto turístico (artigo) a ser exibido 
$id = (int) ($_REQUEST['id'] ?? 0);

//Se não houver ID válido, volta para a página inicial
if (!$id) {
    header('Location: /');
    exit();
}

//Busca o artigo/ponto turístico pelo ID
$ponto = Artigo::get($id);

//Se o artigo não existir, volta para a página inicial
if (!$ponto) {
    header('Location: /');
    exit();
}

//Busca os comentários relacionados a este ponto turístico
$comentarios = FaleConosco::porArtigo($id);

view('ponto', compact('ponto', 'comentarios'));