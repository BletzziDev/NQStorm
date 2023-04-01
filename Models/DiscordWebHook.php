<?php

namespace Models;
use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;
require 'vendor/autoload.php';

class DiscordWebHook
{
    public function __construct(Array $webhook_info)
    {
        $webhook = new Client($webhook_info["url"]);
        $embed = new Embed();

        $embed->description($webhook_info["description"]);

        $webhook->username($webhook_info["username"])->message($webhook_info["message"])->embed($embed)->send();
    }
    /*

      |========================|
      |  TEMPLATE DE WEBHOOK  |
     |========================|

    $webhook = new \Models\DiscordWebHook([
        "url"=>"link_webhook_discord",
        "description"=>"
        A descrição da sua embed
        Pode ter quebra de linhas
        ",
        "username"=>"Nome de usuário da webhook",
        "message"=>"Mensagem caso queira utilizar!"
    ]);

    */
}