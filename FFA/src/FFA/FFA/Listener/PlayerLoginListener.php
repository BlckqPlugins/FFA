<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use FFA\FFA\Utils\FFAPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

class PlayerLoginListener implements Listener {

    public function onLogin(PlayerLoginEvent $event){
        $player = $event->getPlayer();
        Main::$ffaplayers[$event->getPlayer()->getName()] = new FFAPlayer($event->getPlayer());
    }

}