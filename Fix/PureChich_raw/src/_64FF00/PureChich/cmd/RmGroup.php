<?php

namespace _64FF00\PureChich\cmd;

use _64FF00\PureChich\PureChich;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class RmGroup extends Command implements PluginIdentifiableCommand
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
        
        $this->setPermission("pchich.command.rmgroup");
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
        
        if(!isset($args[0]) || count($args) > 1)
        {
            $sender->sendMessage(TextFormat::GREEN . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmgroup.usage"));
            
            return true;
        }

        $result = $this->plugin->removeGroup($args[0]);
        
        if($result === PureChich::SUCCESS)
        {
            $sender->sendMessage(TextFormat::GREEN . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmgroup.messages.group_removed_successfully", $args[0]));
        }
        elseif($result === PureChich::INVALID_NAME)
        {
            $sender->sendMessage(TextFormat::RED . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmgroup.messages.invalid_group_name", $args[0]));
        }
        else
        {
            $sender->sendMessage(TextFormat::RED . PureChich::MAIN_PREFIX . ' ' . $this->plugin->getMessage("cmds.rmgroup.messages.group_not_exist", $args[0]));
        }
        
        return true;
    }
    
    public function getPlugin() : Plugin
    {
        return $this->plugin;
    }
}