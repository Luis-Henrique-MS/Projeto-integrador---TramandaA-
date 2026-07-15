<?php

// Renderiza uma view dentro do template principal (app.php), transformando $data em variáveis locais
function view($view, $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }

    require __DIR__ . '/view/template/app.php';
}

// Igual à função view(), mas usa um template alternativo (app2.php)
function view2($view2, $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }

    require __DIR__ . '/view/template/app2.php';
}

// Função de debug: exibe o conteúdo de variáveis formatado e interrompe a execução
function dd(...$dump)
{
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
    die();
}

// Interrompe a requisição retornando um código HTTP e exibindo a view de erro correspondente
function abort($code)
{
    http_response_code($code);
    view($code);
    die();
}

// Atalho para criar uma instância de mensagens flash (usadas para feedback entre requisições)
function flash()
{
    return new Flash();
}

// Lê o arquivo de configuração; retorna tudo ou apenas uma chave específica
function config($chave = null)
{
    $config = require __DIR__ . '/config.php';

    if (strlen($chave) > 0) {
        return $config[$chave];
    }

    return $config;
}
