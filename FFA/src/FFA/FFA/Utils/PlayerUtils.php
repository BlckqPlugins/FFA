<?php

namespace FFA\FFA\Utils;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\Server;

class PlayerUtils {

    public static function giveItems(Player $player){
        $inventory = $player->getInventory();
        $armorinv = $player->getArmorInventory();

        $inventory->clearAll();
        $armorinv->clearAll();

        $player->getEffects()->clear();

        //Enchants
        $sharpness = new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 1);
        $protection = new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 1);
        $power = new EnchantmentInstance(VanillaEnchantments::POWER(), 1);

        //Items
        $sword = VanillaItems::IRON_SWORD()->setUnbreakable(true);
        $sword->addEnchantment($sharpness);

        $bow = VanillaItems::BOW()->setUnbreakable(true);
        $bow->addEnchantment($power);

        $arrow = VanillaItems::ARROW()->setCount(12);

        $helmet = VanillaItems::IRON_HELMET()->setUnbreakable(true);
        $helmet->addEnchantment($protection);

        $chestplate = VanillaItems::IRON_CHESTPLATE()->setUnbreakable(true);
        $chestplate->addEnchantment($protection);

        $leggings = VanillaItems::IRON_LEGGINGS()->setUnbreakable(true);
        $leggings->addEnchantment($protection);

        $boots = VanillaItems::IRON_BOOTS()->setUnbreakable(true);
        $boots->addEnchantment($protection);

        $inventory->setItem(0, $sword);
        $inventory->setItem(1, $bow);
        $inventory->setItem(8, $arrow);

        $armorinv->setHelmet($helmet);
        $armorinv->setChestplate($chestplate);
        $armorinv->setLeggings($leggings);
        $armorinv->setBoots($boots);

        $player->setHealth(20);
        $player->getHungerManager()->setFood(20);
    }

    public static function die(Player $player){
        self::giveItems($player);
        $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
    }

}