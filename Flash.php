<?php

// Classe para armazenar mensagens temporárias na sessão (ex: sucesso/erro após um redirect)
class Flash
{

    // Guarda um valor na sessão sob uma chave prefixada com "flash_"
    public function push($chave, $valor)
    {
        $_SESSION["flash_$chave"] = $valor;
    }

    // Recupera (e remove) o valor da sessão; retorna false se não existir
    public function get($chave)
    {

        if (! isset($_SESSION["flash_$chave"])) {
            return false;
        }

        $valor = $_SESSION["flash_$chave"];
        unset($_SESSION["flash_$chave"]);
        return $valor;
    }
}
