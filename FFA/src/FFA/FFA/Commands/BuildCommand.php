<?php

namespace FFA\FFA\Commands;

use FFA\FFA\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class BuildCommand extends Command {

    public function __construct()
    {
        parent::__construct("build", "Build Command", "/build", []);
        $this->setPermission("ffa.command.build");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)){
            $sender->sendMessage("§cYou can't use this command.");
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("§cYou must be an player to execute this command.");
            return false;
        }

        $mplayer = Main::$ffaplayers[$sender->getName()];
        if (!$mplayer->isCanBuild()){
            $mplayer->setCanBuild(true);
            $message = Main::getInstance()->getConfig()->get("message-player-canBuild");
        } else {
            $mplayer->setCanBuild(false);
            $message = Main::getInstance()->getConfig()->get("message-player-cantBuild");
        }
        $message = str_replace("&", "§", $message);
        $message = str_replace("{prefix}", Main::getInstance()->getConfig()->get("prefix"), $message);
        $mplayer->getPlayer()->sendMessage($message);
        return true;
    }

}