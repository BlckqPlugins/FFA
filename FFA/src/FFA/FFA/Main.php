<?php

namespace FFA\FFA;

use FFA\FFA\Commands\BuildCommand;
use FFA\FFA\Listener\PlayerBlockListener;
use FFA\FFA\Listener\PlayerDamageListener;
use FFA\FFA\Listener\PlayerDropListener;
use FFA\FFA\Listener\PlayerHungerListener;
use FFA\FFA\Listener\PlayerJoinListener;
use FFA\FFA\Listener\PlayerLoginListener;
use FFA\FFA\Listener\PlayerPickupListener;
use FFA\FFA\Listener\PlayerQuitListener;
use FFA\FFA\Utils\FFAPlayer;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Main extends PluginBase {

    public static $prefix = "§l§eFFA §7> §r";
    private static $instance;
    /** @var FFAPlayer[] */
    public static $ffaplayers = [];


    public function onEnable(): void
    {
        self::$instance = $this;
        $this->saveResource("config.yml", false);

        $pm = $this->getServer()->getPluginManager();
        $pm->registerEvents(new PlayerDamageListener(), $this);
        $pm->registerEvents(new PlayerDropListener(), $this);
        $pm->registerEvents(new PlayerHungerListener(), $this);
        $pm->registerEvents(new PlayerJoinListener(), $this);
        $pm->registerEvents(new PlayerPickupListener(), $this);
        $pm->registerEvents(new PlayerQuitListener(), $this);
        $pm->registerEvents(new PlayerLoginListener(), $this);
        $pm->registerEvents(new PlayerBlockListener(), $this);

        Server::getInstance()->getCommandMap()->register("build", new BuildCommand());
    }

    /**
     * @return Main
     */
    public static function getInstance(): Main
    {
        return self::$instance;
    }
}