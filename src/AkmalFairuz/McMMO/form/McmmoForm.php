<?php

/*
 *
 *              _                             _        ______             _
 *     /\      | |                           | |      |  ____|           (_)
 *    /  \     | | __   _ __ ___      __ _   | |      | |__       __ _    _    _ __    _   _    ____
 *   / /\ \    | |/ /  | '_ ` _ \    / _` |  | |      |  __|     / _` |  | |  | '__|  | | | |  |_  /
 *  / ____ \   |   <   | | | | | |  | (_| |  | |      | |       | (_| |  | |  | |     | |_| |   / /
 * /_/    \_\  |_|\_\  |_| |_| |_|   \__,_|  |_|      |_|        \__,_|  |_|  |_|      \__,_|  /___|
 *
 * Discord: akmal#7191
 * GitHub: https://github.com/AkmalFairuz
 *
 */

namespace AkmalFairuz\McMMO\form;

use jojoe77777\FormAPI\FormAPI;
use AkmalFairuz\McMMO\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;

class McmmoForm
{
    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function init(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
            if($data === null) {
                return;
            }
            switch($data) {
                case 0:
                    $this->stats($player);
                    return;
                case 1:
                    $this->leaderboard($player);
                    return;
            }
        });
        $form->setTitle("McMMO");
        $form->addButton("Your stats");
        $form->addButton("Leaderboard");
        $form->sendToPlayer($player);
    }

    public function stats(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
            if($data !== null) {
                $this->leaderboard($player);
            }
        });
        $form->setTitle("§l§aMCMMO STATS");
        $content = [
            "§6> §7MCMMO Stats Of §b{$player->getName()} §6<",
            "",
            "§f----------",
            "§6Lumberjack: ",
            "§7XP: §a".$this->plugin->getXp(Main::LUMBERJACK, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::LUMBERJACK, $player),
            "§f----------",
            "§6Farming: ",
            "§7XP: §a".$this->plugin->getXp(Main::FARMER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::FARMER, $player),
            "§f----------",
            "§6Excavation: ",
            "§7XP: §a".$this->plugin->getXp(Main::EXCAVATION, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::EXCAVATION, $player),
            "§f----------",
            "§6Mining: ",
            "§7XP: §a".$this->plugin->getXp(Main::MINER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::MINER, $player),
            "§f----------",
            "§6Kills: ",
            "§7XP: §a".$this->plugin->getXp(Main::KILLER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::KILLER, $player),
            "§f----------",
            "§6Combat: ",
            "§7XP: §a".$this->plugin->getXp(Main::COMBAT, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::COMBAT, $player),
            "§f----------",
            "§6Building: ",
            "§7XP: §a".$this->plugin->getXp(Main::BUILDER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::BUILDER, $player),
            "§f----------",
            "§6Consuming: ",
            "§7XP: §a".$this->plugin->getXp(Main::CONSUMER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::CONSUMER, $player),
            "§f----------",
            "§6Archering: ",
            "§7XP: §a".$this->plugin->getXp(Main::ARCHER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::ARCHER, $player),
            "§f----------",
            "§6Lawn Mowing: ",
            "§7XP: §a".$this->plugin->getXp(Main::LAWN_MOWER, $player),
            "§7Level: §e".$this->plugin->getLevel(Main::LAWN_MOWER, $player),
            "§f----------"
        ];
        $form->setContent(implode("\n", $content));
        $form->addButton("Back");
        $form->sendToPlayer($player);
    }

    public function leaderboard(Player $player) {
        $a = ["Lumberjack", "Farming", "Excavation", "Mining", "Kills", "Combat", "Building", "Consuming", "Archering", "Lawn Mowing"];
        $form = new SimpleForm(function (Player $player, $data) use ($a) {
            if($data === null) {
                return;
            }
            if ($data === 0) {
                $this->stats($player);
                return false;
            }

            if ($data !== 0) {
                $this->leaderboards($player, $data - 1);
                return false;
            }
        });
        $form->setTitle("§l§6MCMMO");
        $form->addButton("§lMMO STATS");
        foreach($a as $as) {
            $text = "§lTOP ".strtoupper($as);
            $form->addButton($text);
        }
        $form->sendToPlayer($player);
    }


    public function leaderboards(Player $player, int $type) {
        $form = new SimpleForm(function (Player $player, $data) {
            if($data !== null) {
                $this->leaderboard($player);
            }
        });
        $a = ["Lumberjack", "Farmer", "Excavation", "Miner", "Killer", "Combat", "Builder", "Consumer", "Archer", "Lawn Mower"];
        $and = ["Lumberjack", "Farming", "Excavation", "Mining", "Kills", "Combat", "Building", "Consuming", "Archering", "Lawn Mowing"];
        $form->setTitle("§l§aTOP ".strtoupper($and[$type]));
        $content = "";
        $a = $this->plugin->getAll($type);
        arsort($a);
        $i = 1;
        foreach($a as $key => $as) {
            if($i == 20) break;
            $content .= "§f[".$i."] - §b".$key . " §alevel §e".$as."\n";
            $i++;
        }
        $form->setContent($content."\n");
        $form->addButton("§l§cBACK");
        $form->sendToPlayer($player);
    }
}
