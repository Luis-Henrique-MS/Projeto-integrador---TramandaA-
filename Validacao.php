<?php

// Classe responsável por validar dados de formulários com base em regras declarativas
class Validacao
{

    // Armazena as mensagens de erro geradas durante a validação
    public $validacoes = [];

    // Recebe as regras (ex: ['nome' => ['required']]) e os dados enviados, e executa cada regra
    public static function validar($regras, $dados)
    {


        /**
         * 
         * Campo = nome , email
         * Regra = required, email
         * 
         */

        $validacao = new self;

        // Percorre cada campo e suas respectivas regras de validação
        foreach ($regras as $campo => $regrasDoCampo) {

            foreach ($regrasDoCampo as $regra) {
                $valorDocampo = $dados[$campo];

                // Regra "confirmed" compara o campo com seu campo de confirmação (ex: senha_confirmacao)
                if ($regra == 'confirmed') {
                    $validacao->$regra($campo, $valorDocampo, $dados["{$campo}_confirmacao"]);
                } else if (str_contains($regra, ':')) {
                    // Regras com parâmetro (ex: "min:6") são separadas em nome da regra e argumento
                    $temp = explode(':', $regra);
                    $regra = $temp[0];
                    $regraAr = $temp[1];

                    $validacao->$regra($campo, $regraAr, $valorDocampo);
                } else {
                    // Regras simples (ex: "required", "email") são chamadas diretamente
                    $validacao->$regra($campo, $valorDocampo);
                }
            }
        }

        return $validacao;
    }

    // Valida se o campo não está vazio
    private function required($campo, $valor)
    {

        if (strlen($valor) == 0) {
            $this->validacoes[] = "O $campo é obrigatorio!";
        }
    }

    // Valida se o valor é um e-mail válido
    private function email($campo, $valor)
    {
        if (! filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            $this->validacoes[] = "O $campo deve ser um $campo valido!";
        }
    }

    // Valida se o campo é igual ao seu campo de confirmação
    private function confirmed($campo, $valor, $confirmed)
    {
        if ($valor != $confirmed) {
            $this->validacoes[] = "$campo confirmação esta diferente!";
        }
    }

    // Valida se o valor tem no mínimo X caracteres
    private function min($campo, $regraAr, $valor)
    {
        if (strlen($valor) < $regraAr) {
            $this->validacoes[] = "A $campo tem que ter no minimo $regraAr caracteres";
        }
    }

    // Valida se o valor tem no máximo X caracteres
    private function max($campo, $regraAr, $valor)
    {
        if (strlen($valor) > $regraAr) {
            $this->validacoes[] = "A $campo tem que ter no maximo $regraAr caracteres";
        }
    }

    // Valida se o valor contém ao menos um caractere especial
    private function strong($campo, $valor)
    {
        if (!strpbrk($valor, '!@#$%^*&()?/')) {
            $this->validacoes[] = "O $campo tem que ter um caracter especial!";
        }
    }

    // Valida se o valor já existe na tabela informada (ex: e-mail único)
    private function unique($campo, $tabela, $valor)
    {
        if (strlen($valor) == 0) {
            return;
        }

        $db = new DB(config('database'));

        $resultado = $db->query(
            sql: "select * from $tabela where $campo = :valor",
            params: compact('valor')
        )->fetch();

        if ($resultado) {
            $this->validacoes[] = "O $campo ja existe!";
        }
    }

    // Verifica se a validação falhou; se sim, salva os erros na flash session para exibição
    public function naoPassou($nomeCustomizado = null)
    {

        $chave = 'validacoes';

        if ($nomeCustomizado) {
            $chave .= '_' . $nomeCustomizado;
        }

     
        flash()->push($chave, $this->validacoes);
        return sizeof($this->validacoes) > 0;
    }
}
