<?php

// Ponto de entrada da aplicação: carrega os models
require __DIR__ . '/Models/Feadbeck.php';
require __DIR__ . '/Models/Artigo.php';
require __DIR__ . '/Models/Usuario.php';

// Inicia a sessão PHP (necessária para login e mensagens flash)
session_start();

// Carrega utilitários de mensagens flash, funções auxiliares e validação
require __DIR__ . '/Flash.php';
require __DIR__ . '/function.php';
require __DIR__ . '/Validacao.php';

// Carrega as configurações do banco e abre a conexão
$config = require __DIR__ . '/config.php';
require __DIR__ . '/database.php';

// Carrega as rotas e despacha a requisição atual
require __DIR__ . '/route.php';



