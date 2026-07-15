<?php

// Configurações de conexão com o banco de dados usadas pela classe Database
return [
    'database' => [
        // 'driver' => 'sqlite',
        // 'database' => 'database.sqlite'

        'driver' => 'mysql', // SGBD utilizado
        'host' => 'localhost', // Endereço do servidor MySQL
        'port' => 3306, // Porta padrão do MySQL
        'dbname' => 'tramandaai', // Nome do banco de dados
        'user' => 'root', // Usuário de acesso ao banco
        'password' => '', // Senha de acesso ao banco
        'charset' => 'utf8mb4' // Charset da conexão (suporta emojis e acentos)
    ]
];
