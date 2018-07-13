<?php 
class Database extends PDO
{
    private static $connection = null;

    public function __construct(){
        $params = [
            'host' => '',
            'dbname' => '',
            'charset' => 'utf8',
            'user' => '',
            'password' => '',
            'options' => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]
        ];

        $dsn = "mysql:host={$params['host']};
            dbname={$params["dbname"]};
            charset={$params['charset']}"; 

        parent::__construct(
            $dsn, $params['user'],
            $params['password'],
            $params['options']
        );
    }

    public static function getConnection()
    {
        if(self::$connection === null) {
            self::$connection = new self;
        }

        return self::$connection;
    }

}