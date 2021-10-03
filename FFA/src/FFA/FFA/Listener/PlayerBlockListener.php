<?php

namespace FFA\FFA\Listener;

use FFA\FFA\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

class PlayerBlockListener implements Listener {

    public function onPlace(BlockPlaceEvent $event){
        if (!Main::$ffaplayers[$event->getPlayer()->getName()]->isCanBuild()) $event->cancel();
    }

    public function onBreak(BlockBreakEvent $event){
        if (!Main::$ffaplayers[$event->getPlayer()->getName()]->isCanBuild()) $event->cancel();
    }
}