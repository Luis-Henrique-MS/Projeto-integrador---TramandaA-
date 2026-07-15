<?php

// Classe responsável pela conexão PDO e por executar queries no banco
class DB
{
    public $db;

    // Abre a conexão PDO usando as configurações recebidas
    public function __construct($config)
    {
        $this->db = new PDO(
            $this->getDsn($config),
            $config['user'] ?? null,
            $config['password'] ?? null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceção em caso de erro SQL
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna resultados como array associativo por padrão
                PDO::ATTR_EMULATE_PREPARES => false, // Usa prepared statements nativos do driver
            ]
        );
    }

    // Monta a string de conexão (DSN) de acordo com o driver configurado (mysql ou sqlite)
    private function getDsn($config)
    {
        $driver = $config['driver'];
        $dsnConfig = $config;
        unset($dsnConfig['driver']);

        if ($driver === 'sqlite') {
            return $driver . ':' . ($dsnConfig['database'] ?? 'database.sqlite');
        }

        return $driver . ':' . http_build_query($dsnConfig, '', ';');
    }

    // Busca artigos cujo título, data ou descrição contenham o termo pesquisado
    public function artigos($pesquisar)
    {
        //     $prepare = $this->db->prepare("select * from artigo where titulo like :pesquisar or dataPublicacao like :pesquisar or descricao like :pesquisar");
        //     $prepare->bindValue('pesquisar', "%$pesquisar%");
        //     $prepare->setFetchMode(PDO::FETCH_CLASS, Artigo::class);
        //     $prepare->execute();
        //     return $prepare->fetchAll();


        // 36: Use marcadores diferentes para cada coluna
        $prepare = $this->db->prepare("SELECT * FROM artigo WHERE titulo LIKE :titulo OR dataPublicacao LIKE :data OR descricao LIKE :desc");

        // 37: Associe o valor de pesquisa (com %) a cada um dos marcadores únicos
        $valorPesquisa = '%' . $pesquisar . '%';
        $prepare->bindValue('titulo', $valorPesquisa);
        $prepare->bindValue('data', $valorPesquisa);
        $prepare->bindValue('desc', $valorPesquisa);
        // Observação: faltam execute() e return aqui, a função não retorna resultados
    }

    // Busca um único artigo pelo ID e retorna como instância da classe Artigo
    public function artigo($id)
    {
        $prepare = $this->db->prepare("select * from artigo where id = :id");
        $prepare->bindValue('id', $id);
        $prepare->setFetchMode(PDO::FETCH_CLASS, Artigo::class);
        $prepare->execute();

        return $prepare->fetch();
    }

    // Executa qualquer SQL genérico, opcionalmente mapeando o resultado para uma classe
    public function query($sql, $class = null, $params = [])
    {
        $prepare = $this->db->prepare($sql);
        if ($class) {
            $prepare->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        $prepare->execute($params);
        return $prepare;
    }
}

// Instancia a conexão global usada em todo o projeto
$database = new DB($config['database']);
