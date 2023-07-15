<?php

namespace FFA\FFA\Commands;

use FFA\FFA\Main;
use FFA\FFA\Utils\PlayerUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

class SpectateCommand extends Command
{

    public function __construct()
    {
        parent::__construct("spectate", "Spectate Command", "/spectate", []);
        $this->setPermission("ffa.command.spectate");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            $sender->sendMessage("§cYou can't use this command.");
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("§cYou must be an player to execute this command.");
            return false;
        }

        $mplayer = Main::$ffaplayers[$sender->getName()];
        if (!$mplayer->isSpectator()) {
            $mplayer->setSpectator(true);
            $message = Main::getInstance()->getConfig()->get("message-spectating-enabled") ?? "§aYou are now spectating§7.";

            $mplayer->getPlayer()->setGamemode(GameMode::SPECTATOR());
            $mplayer->getPlayer()->getInventory()->clearAll();
        } else {
            $mplayer->setSpectator(false);
            $message = Main::getInstance()->getConfig()->get("message-spectating-disabled") ?? "§cYou are no longer spectating§7.";

            $mplayer->getPlayer()->setGamemode(GameMode::SURVIVAL());
            PlayerUtils::die($mplayer->getPlayer());
        }
        $message = str_replace("&", "§", $message);
        $message = str_replace("{prefix}", Main::getInstance()->getConfig()->get("prefix"), $message);
        $mplayer->getPlayer()->sendMessage($message);
        return true;
    }
}