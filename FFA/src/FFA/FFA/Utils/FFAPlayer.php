<?php

namespace FFA\FFA\Utils;

use pocketmine\player\Player;

class FFAPlayer {

    /** @var Player */
    protected $player;
    /** @var bool */
    protected $isSpectator = FALSE;
    /** @var bool */
    protected $canBuild = FALSE;


    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * Function getPlayer
     * @return Player
     */
    public function getPlayer(): Player{
        return $this->player;
    }

    /**
     * @param bool $isSpectator
     */
    public function setSpectator(bool $isSpectator = TRUE): void
    {
        $this->isSpectator = $isSpectator;
    }

    /**
     * @return bool
     */
    public function isSpectator(): bool{
        return $this->isSpectator;
    }

    /**
     * @param bool $canBuild
     */
    public function setCanBuild(bool $canBuild): void
    {
        $this->canBuild = $canBuild;
    }

    /**
     * @return bool
     */
    public function isCanBuild(): bool{
        return $this->canBuild;
    }

}