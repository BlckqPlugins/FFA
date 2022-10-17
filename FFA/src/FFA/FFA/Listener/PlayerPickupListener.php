<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerBlockPickEvent;

class PlayerPickupListener implements Listener {

    public function onPickup(PlayerBlockPickEvent $event){
        if (!Main::getInstance()->getConfig()->get("enable-pickup", false)){
            $event->cancel();
        }
    }

}