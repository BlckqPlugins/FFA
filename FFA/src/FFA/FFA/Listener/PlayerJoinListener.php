<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use FFA\FFA\Utils\PlayerUtils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

class PlayerJoinListener implements Listener {

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $event->setJoinMessage("");

        $mplayer = Main::$ffaplayers[$event->getPlayer()->getName()];
        $mplayer->setCanBuild(false);
        $mplayer->setSpectator(false);

        foreach (Server::getInstance()->getOnlinePlayers() as $oply){
            if (Main::getInstance()->getConfig()->get("enable-joinmessage")){
                $joinmessage = Main::getInstance()->getConfig()->get("message-player-joined");
                $joinmessage = str_replace("&", "§", $joinmessage);
                $joinmessage = str_replace("{player}", $player->getDisplayName(), $joinmessage);
                $oply->sendMessage($joinmessage);
            }
        }
        $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
        PlayerUtils::giveItems($player);
    }
}