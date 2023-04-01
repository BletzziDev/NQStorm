<?php

namespace Controllers;

class Config
{
    public function get()
    {
        $config = file_get_contents("app.json");
        $config = json_decode($config,true);
        return $config;
    }
}