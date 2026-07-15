<?php

//Encerra a sessão do usuário (logout)
session_destroy();

//Redireciona de volta para a página inicial
header("Location: /index");

exit();