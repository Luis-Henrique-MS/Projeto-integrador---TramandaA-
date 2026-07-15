<?php

// Extrai o caminho da URL requisitada (ex: "/login" -> "login")
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$controller = trim(str_replace('/', '', $path));

// Se o caminho estiver vazio, usa o controller "index" como padrão
if (! $controller) {
    $controller = 'index';
}

// Se não existir um controller com esse nome, retorna erro 404
if (! file_exists(__DIR__ . '/controller/' . $controller . '.controller.php')) {
    abort(404);
}

// Carrega e executa o controller correspondente à rota
require __DIR__ . '/controller/' . $controller . '.controller.php';


