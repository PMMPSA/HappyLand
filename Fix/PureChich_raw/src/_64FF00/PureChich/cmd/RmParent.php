<?php

namespace _64FF00\PureChich\cmd;

use _64FF00\PureChich\PureChich;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class RmParent extends Command implements PluginIdentifiableCommand
{
    /*
        PureChich by 64FF00 (Twitter: @64FF00)

          888  888    .d8888b.      d8888  8888888888 8888888888 .d8888b.   .d8888b.
          888  888   d88P  Y88b    d8P888  888        888       d88P  Y88b d88P  Y88b
        888888888888 888          d8P 888  888        888       888    888 888    888
          888  888   888d888b.   d8P  888  8888888    8888888   888    888 888    888
          888  888   888P "Y88b d88   888  888        888       888    888 888    888
        888888888888 888    888 8888888888 888        888       888    888 888    888
          888  888   Y88b  d88P       888  888        888       Y88b  d88P Y88b  d88P
          888  888    "Y8888P"        888  888        888        "Y8888P"   "Y8888P"
    */

    private $plugin;

    /**
     * @param PureChich $plugin
     * @param $name
     * @param $description
     */
    public function __construct(PureChich $plugin, $name, $description)
    {
        $this->plugin = $plugin;
        
        parent::__construct($name, $description);
        
        $this->setPermission("pchich.command.rmparent");
    }

    /**
     * @param CommandSender $sender
     * @param $label
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $label, array $args) : bool
    {
        if(!$this->testPermission($sender))
            return false;

        if(count($args) < 2 || count($args) > 3)
        {
            $sender->sendMessage(TextFormat::GREEN . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmparent.usage"));

            return true;
        }

        $target_group = $this->plugin->getGroup($args[0]);

        $parent_group = $this->plugin->getGroup($args[1]);

        $target_group->removeParent($parent_group);

        $sender->sendMessage(TextFormat::GREEN . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmparent.messages.rmparent_successfully", $parent_group->getName(), $target_group->getName()));

        return true;
    }
    
    public function getPlugin() : Plugin
    {
        return $this->plugin;
    }
}