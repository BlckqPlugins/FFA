<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;

class PlayerDropListener implements Listener {

    public function onDrop(PlayerDropItemEvent $event){
        if (!Main::getInstance()->getConfig()->get("enable-drops")) $event->cancel();
    }

}