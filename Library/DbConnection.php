<?php
namespace Library;
class DbConnection
{
    public static $instance;
    private $pdo;

    private function __construct()
    {
        $dsn = 'mysql: host=' . Config::get('host') . '; dbname='. Config::get('dbname');
        
        $this->pdo = new \PDO($dsn, Config::get('user'), Config::get('pass'));
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    

    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance()
    {
        if (self::$instance === null){
            self::$instance = new DbConnection();
        } return self::$instance = new DbConnection();
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}