<?php

namespace FFA\FFA\Utils;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
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
        $sword = ItemFactory::getInstance()->get(ItemIds::IRON_SWORD);
        $sword->addEnchantment($sharpness);

        $bow = ItemFactory::getInstance()->get(ItemIds::BOW);
        $bow->addEnchantment($power);

        $arrow = ItemFactory::getInstance()->get(ItemIds::ARROW, 0, 12);

        $helmet = ItemFactory::getInstance()->get(ItemIds::IRON_HELMET);
        $helmet->addEnchantment($protection);

        $chestplate = ItemFactory::getInstance()->get(ItemIds::IRON_CHESTPLATE);
        $chestplate->addEnchantment($protection);

        $leggings = ItemFactory::getInstance()->get(ItemIds::IRON_LEGGINGS);
        $leggings->addEnchantment($protection);

        $boots = ItemFactory::getInstance()->get(ItemIds::IRON_BOOTS);
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