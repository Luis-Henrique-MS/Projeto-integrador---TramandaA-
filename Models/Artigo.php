<?php

//Representa um artigo/ponto turístico e concentra as operações de banco relacionadas
class Artigo
{


    public $id;
    public $titulo;
    public $dataPublicacao;
    public $descricao;
    public $img;
    public $link;
    public $id_usuario;
    public $endereco;
    public $horario;


    //Executa uma consulta SELECT genérica na tabela artigo, mapeando o resultado para esta classe
    public function query($where, $params)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "SELECT * FROM artigo where $where",
            class: self::class,
            params: $params
        );
    }

    //Busca um artigo específico pelo ID
    public static function get($id)
    {

        return (new self)->query(
            'id = :id',
            ['id' => "$id"]
        )->fetch();
    }

    //Lista todos os artigos, filtrando por título ou descrição
    public static function all($filtro)
    {
        return (new self)->query(
            'titulo like :filtro1 or descricao like :filtro2',
            ['filtro1' => "%$filtro%", 'filtro2' => "%$filtro%"]
        )->fetchAll();
    }

    //Lista os artigos pertencentes a um usuário específico 
    public static function meus($usuario_id)
    {
        return (new self)->query(
            'id_usuario = :id_usuario',
            ['id_usuario' => "$usuario_id"]
        )->fetchAll();
    }

    //Insere um novo artigo no banco de dados
    public static function criar($dados)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "INSERT INTO artigo (titulo, dataPublicacao, descricao, img, link, endereco, horario, id_usuario) 
              VALUES (:titulo, :dataPublicacao, :descricao, :img, :link, :endereco, :horario, :id_usuario)",
            class: self::class,
            params: $dados
        );
    }

    //Remove um artigo pelo ID
    public static function deletar($id)
    {
        $database = new DB(config('database'));

        return $database->query(
            sql: "DELETE FROM artigo WHERE id = :id",
            class: self::class,
            params: ['id' => $id]
        );
    }
}
