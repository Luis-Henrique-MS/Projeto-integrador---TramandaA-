<?php

//Pega o termo de pesquisa enviado via GET/POST (ou vazio, se não houver)
$pesquisar = $_REQUEST['pesquisar'] ?? '';

//Busca os artigos que combinam com a pesquisa
$artigos = Artigo::all($pesquisar);

//Renderiza a página inicial com a lista de artigos encontrados
view('index', ['artigos' => $artigos]);