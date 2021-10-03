<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use FFA\FFA\Utils\PlayerUtils;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\Server;

class PlayerDamageListener implements Listener {

    public function onDamage(EntityDamageEvent $event){
        if (!$event instanceof EntityDamageByEntityEvent) $event->cancel();

        $killer = $event->getDamager();
        $victim = $event->getEntity();

        if ($victim->getDirectionVector()->distance($victim->getWorld()->getSafeSpawn()) <= Main::getInstance()->getConfig()->get("spawn-radius") or $killer->getDirectionVector()->distance($killer->getWorld()->getSafeSpawn()) <= Main::getInstance()->getConfig()->get("spawn-radius")) {
            $event->cancel();
        }

        if ($victim instanceof Player && $killer instanceof Player) {
            if ($victim->getHealth() <= $event->getFinalDamage()) {
                if ($victim->getName() !== $killer->getName()) {
                    $event->cancel();
                    PlayerUtils::die($victim);
                    PlayerUtils::giveItems($killer);

                    $config = Main::getInstance()->getConfig();
                    $killmessage = $config->get("message-player-killed");
                    $killmessage = str_replace("&", "§", $killmessage);
                    $killmessage = str_replace("{player}", $victim->getDisplayName(), $killmessage);
                    $killmessage = str_replace("{killer}", $killer->getDisplayName(), $killmessage);
                    $killmessage = str_replace("{prefix}", $config->get("prefix"), $killmessage);

                    foreach (Server::getInstance()->getOnlinePlayers() as $oply){
                        $oply->sendMessage($killmessage);
                    }

                } else {
                    $event->cancel();
                }
            }
        }
    }
}