<?php

//Representa um comentário/feedback deixado por um visitante em um artigo (ponto turístico)
class FaleConosco
{
    public $id;
    public $nome;
    public $comentario;
    public $foto;
    public $nota;
    public $artigo_id;

    //Executa um SELECT genérica na tabela fale_conosco, mapeando o resultado para esta classe
    public function query($where, $params)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "SELECT * FROM fale_conosco where $where",
            class: self::class,
            params: $params
        );
    }

    //Lista todos os comentários de um artigo específico, do mais recente para o mais antigo
    public static function porArtigo($artigo_id)
    {
        return (new self)->query(
            'artigo_id = :artigo_id ORDER BY id DESC',
            ['artigo_id' => "$artigo_id"]
        )->fetchAll();
    }

    //Insere um novo comentário no banco de dados
    public static function salvar($dados)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "INSERT INTO fale_conosco (nome, comentario, foto, nota, artigo_id) 
                  VALUES (:nome, :comentario, :foto, :nota, :artigo_id)",
            class: self::class,
            params: $dados
        );
    }

    //Lista todos os comentários existentes, do mais recente para o mais antigo
    public static function all()
    {
        return (new self)->query('1=1 ORDER BY id DESC', [])->fetchAll();
    }

    //Remove um comentário pelo ID
    public static function deletar($id)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "DELETE FROM fale_conosco WHERE id = :id",
            class: self::class,
            params: ['id' => $id]
        );
    }
}
