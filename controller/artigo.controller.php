<?php

//Busca um artigo específico pelo ID recebido na requisição 
$artigo = $database->artigo($_REQUEST['id']);


view('artigo', compact('artigo'));