<?php

namespace Models;

use Controllers\Database;

class Users
{
    private $id;
    private $user;
    private $email;
    private $password;
    public function __construct($user,$email,$password)
    {
        $this->user = $user;
        $this->email = $email;
        $this->password = $password;
        $database = new Database();
        $stmt = $database->get()->prepare("INSERT INTO `users` (`username`,`email`,`password`) VALUES (?,?,?)");
        if($stmt->execute(array($user,$email,$password)))
        {
            echo "USER CADASTRADO COM SUCESSO NO BANCO DE DADOS!";
        }else {$app = new \Application();$app->sendHttpError();}
    }
}