<?php

//Se o formulário de login foi enviado (POST), processa a autenticação 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //Valida se e-mail e senha foram preenchidos e se o e-mail é válido 
    $validacao = Validacao::validar([
        'email' => ['required', 'email'],
        'senha' => ['required']
    ], $_POST);


    //Se a validação falhar, volta para o login exibindo os erros
    if ($validacao->naoPassou('login')) {

        header("Location: /login");
        exit();
    }

    //Busca o usuário pelo e-mail informado 
    $usuario = $database->query(
        sql: "select * from usuario where email = :email",
        class: Usuario::class,
        params: compact('email')
    )->fetch();

    if ($usuario) {

        $senhaDoPost = $_POST['senha'];

        $senhaDoBanco = $usuario->senha;


        //Compara a senha digitada com o hash salvo no banco
        if (!password_verify($senhaDoPost, $senhaDoBanco)) {

            flash()->push('validacoes_login', ['Usuario ou senha estão incorretos']);
            header('Location: /login');
            exit();
        }


        //Login bem-sucedido: guarda o usuário na sessão
        $_SESSION['auth'] = $usuario;

        flash()->push('mensagem', "Seja bem vindo " .  $_SESSION['auth']->nome);

        header("Location: /");
        exit();
    }


    //Nenhum usuário encontrado com o e-mail informado
    flash()->push('validacoes_login', ['Usuario ou senha estão incorretos']);
    header('Location: /login');
    exit();
}

//Requisição GET: apenas exibe o formulário de login 
view('login');
