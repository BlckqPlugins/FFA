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

    public function onDamage(EntityDamageByEntityEvent $event){

        $killer = $event->getDamager();
        $victim = $event->getEntity();

        if ($victim->getDirectionVector()->distance($victim->getWorld()->getSafeSpawn()) <= Main::getInstance()->getConfig()->get("spawn-radius", 9) or $killer->getDirectionVector()->distance($killer->getWorld()->getSafeSpawn()) <= Main::getInstance()->getConfig()->get("spawn-radius", 9)) {
            $event->cancel();
        }

        if ($victim instanceof Player && $killer instanceof Player) {
            if ($victim->getHealth() <= $event->getFinalDamage()) {
                $event->cancel();
                if ($victim->getName() !== $killer->getName()) {
                    PlayerUtils::die($victim);
                    PlayerUtils::giveItems($killer);

                    $config = Main::getInstance()->getConfig();
                    $killmessage = $config->get("message-player-killed") ?? "§l§eFFA §7> §r{$victim->getDisplayName()} §cwas killed by §r{$killer->getDisplayName()}§7.";
                    $killmessage = str_replace("&", "§", $killmessage);
                    $killmessage = str_replace("{player}", $victim->getDisplayName(), $killmessage);
                    $killmessage = str_replace("{killer}", $killer->getDisplayName(), $killmessage);
                    $killmessage = str_replace("{prefix}", $config->get("prefix"), $killmessage);

                    foreach (Server::getInstance()->getOnlinePlayers() as $oply){
                        $oply->sendMessage($killmessage);
                    }

                }
            }
        }
    }
}