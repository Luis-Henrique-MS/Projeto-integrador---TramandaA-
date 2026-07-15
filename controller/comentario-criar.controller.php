<?php

//Só aceita o envio de comentário via formulário (POST)
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /');
    exit();
}

$ponto_id = $_POST['ponto_id'] ?? null;
$nome = $_POST['nome'] ?? '';
$comentario = $_POST['comentario'] ?? '';
$nota = $_POST['nota'] ?? 5;

//Valida nome (2 a 60 caracteres) e comentário (5 a 300 caracteres)
$validacao = Validacao::validar([
    'nome' => ['required', 'min:2', 'max:60'],
    'comentario' => ['required', 'min:5', 'max:300'],
], $_POST);

if ($validacao->naoPassou()) {
    header("Location: /ponto?id=$ponto_id");
    exit();
}

$caminhoFoto = null;

//Processa o upload da foto do comentário, se houver
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['foto'];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    $tamanhoMaximo = 5 * 1024 * 1024;

    //Rejeita formatos de imagem não permitidos
    if (!in_array($foto['type'], $tiposPermitidos)) {
        flash()->push('validacoes', ['Formato de foto inválido. Envie uma imagem JPG, PNG ou WEBP.']);
        header("Location: /ponto?id=$ponto_id");
        exit();
    }

    //Rejeita fotos maiores que 5MB
    if ($foto['size'] > $tamanhoMaximo) {
        flash()->push('validacoes', ['A foto é muito grande. O limite é 5MB.']);
        header("Location: /ponto?id=$ponto_id");
        exit();
    }

    //Gera um nome de arquivo único para eitar sobrescrever fotos existentes
    $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $nomeArquivo = 'comentario-' . $ponto_id . '-' . uniqid() . '.' . $extensao;

    $pastaDestino = __DIR__ . '/../view/images/uploads/';

    //Cria a pasta de uploads caso ainda não exista
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }

    //Move o arquivo enviado para a pasta de uploads
    move_uploaded_file($foto['tmp_name'], $pastaDestino . $nomeArquivo);

    $caminhoFoto = '/view/images/uploads/' . $nomeArquivo;
}

//Salva o novo comentário no banco de dados
FaleConosco::salvar([
    'nome' => $nome,
    'comentario' => $comentario,
    'foto' => $caminhoFoto,
    'nota' => $nota,
    'artigo_id' => $ponto_id,
]);

flash()->push('mensagem', 'Comentário enviado com sucesso!');

//Volta para a página do ponto turístico onde o comentário foi feito
header('Location: /ponto?id=' . $ponto_id);
exit();