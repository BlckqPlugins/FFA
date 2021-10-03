<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

class PlayerHungerListener implements Listener {

    public function onHunger(PlayerExhaustEvent $event){
        if (!Main::getInstance()->getConfig()->get("enable-hunger")) $event->cancel();
    }

}