<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use FFA\FFA\Utils\FFAPlayer;
use FFA\FFA\Utils\PlayerUtils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;

class PlayerQuitListener implements Listener {

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $event->setQuitMessage("");

        Main::$ffaplayers[$player->getName()] = new FFAPlayer($player);
        Main::$ffaplayers[$player->getName()]->setSpectator(false);
        Main::$ffaplayers[$player->getName()]->setCanBuild(false);

        foreach (Server::getInstance()->getOnlinePlayers() as $oply){
            if (Main::getInstance()->getConfig()->get("enable-quitmessage") ?? true){
                $quitmessage = Main::getInstance()->getConfig()->get("message-player-left") ?? "§8[§4-§8] §r{$player->getDisplayName()}";
                $quitmessage = str_replace("&", "§", $quitmessage);
                $quitmessage = str_replace("{player}", $player->getDisplayName(), $quitmessage);
                $oply->sendMessage($quitmessage);
            }
        }
    }
}