<?php

//Protege a rota: só usuários autenticados podem criar artigos
if (!isset($_SESSION['auth'])) {
    header('Location: /login');
    exit();
}

//Só aceita a criação via envio de formulário (POST)
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /painel');
    exit();
}

//Valida título (2 a 200 caracteres) e descrição (mínimo 5 caracteres)
$validacao = Validacao::validar([
    'titulo' => ['required', 'min:2', 'max:200'],
    'descricao' => ['required', 'min:5'],
], $_POST);

if ($validacao->naoPassou()) {
    header('Location: /painel');
    exit();
}

$caminhoImagem = null;

//Processa o upload da imagem do artigo, se houver
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $imagem = $_FILES['img'];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    $tamanhoMaximo = 5 * 1024 * 1024;

    //Rejeita formatos de imagem não permitidos 
    if (!in_array($imagem['type'], $tiposPermitidos)) {
        flash()->push('validacoes_painel', ['Formato de imagem inválido. Envie JPG, PNG ou WEBP.']);
        header('Location: /painel');
        exit();
    }

    //Rejeita imagens maiores que 5MB
    if ($imagem['size'] > $tamanhoMaximo) {
        flash()->push('validacoes_painel', ['A imagem é muito grande. O limite é 5MB.']);
        header('Location: /painel');
        exit();
    }

    //Gera um nome de arquivo único para evitar sobrescrever imagens existentes
    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
    $nomeArquivo = 'artigo-' . uniqid() . '.' . $extensao;

    $pastaDestino = __DIR__ . '/../view/images/uploads/';

    //Cria a pasta de uploads caso ainda não exista
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }

    //move o arquivo enviado para a pasta de uploads
    move_uploaded_file($imagem['tmp_name'], $pastaDestino . $nomeArquivo);

    $caminhoImagem = '/view/images/uploads/' . $nomeArquivo;
}

//Salva o novo artigo no banco de dados
Artigo::criar([
    'titulo' => $_POST['titulo'],
    'dataPublicacao' => date('Y-m-d'),
    'descricao' => $_POST['descricao'],
    'img' => $caminhoImagem,
    'link' => $_POST['link'] ?: null,
    'endereco' => $_POST['endereco'] ?: null,
    'horario' => $_POST['horario'] ?: null,
    'id_usuario' => $_SESSION['auth']->id,
]);

//Confirma a criação e volta para o painel
flash()->push('mensagem_painel', 'Ponto turístico adicionado com sucesso!');
header('Location: /painel');
exit();