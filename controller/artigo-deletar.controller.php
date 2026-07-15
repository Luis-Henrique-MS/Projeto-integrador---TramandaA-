<?php

//Protege a rota: só usuários autenticados podem excluir artigos
if (!isset($_SESSION['auth'])) {
    header('Location: /login');
    exit();
}

//Só aceita a exclusão via envio de formulário (POST)
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /painel');
    exit();
}

$id = $_POST['id'] ?? null;

//Se um ID foi informado, remove o artigo correspondente
if ($id) {
    Artigo::deletar($id);
    flash()->push('mensagem_painel', 'Ponto turístico removido.');
}

header('Location: /painel');
exit();