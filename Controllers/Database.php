<?php

namespace Controllers;

class Database
{
    private $server;
    private $port;
    private $database;
    private $user;
    private $password;
    private $connection;
    public function __construct()
    {
        $database_credentials = file_get_contents("app.json");
        $database_credentials = json_decode($database_credentials,true);
        $this->server = $database_credentials[0]["database"]["server"];
        $this->port = $database_credentials[0]["database"]["port"];
        $this->database = $database_credentials[0]["database"]["database"];
        $this->user = $database_credentials[0]["database"]["user"];
        $this->password = $database_credentials[0]["database"]["password"];
        try
        {
            $this->connection = new \PDO("mysql:host=$this->server:$this->port;dbname=$this->database", $this->user, $this->password);
        }catch (\PDOException $e)
        {
            $app = new \Application();
            $app->sendHttpError(500);
        }
    }
    public function get()
    {
        return $this->connection;
    }
}