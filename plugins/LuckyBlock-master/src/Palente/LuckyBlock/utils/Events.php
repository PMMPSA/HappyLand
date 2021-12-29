<?php
namespace Palente\LuckyBlock\utils;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TX;
use Palente\LuckyBlock\Main as MN;
#Events
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
#Other
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\command\ConsoleCommandSender;
class Events implements Listener
{
    public $eco = null;
    public $caller = null;
    public $cnf = null;
    public function __construct(MN $caller){
    	$this->caller = $caller;
    }

    public function onBreak(BlockBreakEvent $event){
    	$block = $event->getBlock();
    	$player = $event->getPlayer();
    	$cnf = $this->caller->config;
    	if($block->getId() == $this->caller->config->get('LuckyBlockId')){
    		#21 possibility
    		$nbchance = mt_rand(0, 20);
    		//MN::$logger->info("Chance N°".$nbchance);
    		$obj = $cnf->get("Chance-".$nbchance);
			if($obj['Type'] == "items"){
    			$item = $obj['idItems'];
    			$amount = $obj['amountItems'];
    			$event->setDrops([Item::get($item,0,$amount)]);
    			$player->sendPopup("You winned Item!!");
    			return;
    		}elseif($obj['Type'] == "blocks"){
    			$theblock = $obj['idBlocks'];
    			$block->getLevel()->setBlock($block->asPosition()->asVector3(),Block::get($theblock), true);
    			$event->setCancelled();
    			$event->setDrops([Item::get(0,0,0)]);
    			return;
    		}elseif($obj['Type'] == "money"){
    			if($this->caller->mode_eco){
    				$money = $obj["moneyToAdd"];
    				$this->caller->EconomyAPI->addMoney($player,$money);
    				$player->sendMessage($this->caller->prefix."Bạn Đã Nhận Được ".$money." Xu! Xin Chúc Mừng§a");
    				$event->setDrops([Item::get(0,0,0)]);
    				return;
    			}else{
    				MN::$logger->warn('Usage of The type money in the case '.$nbchance.' but economy is disabled..');
    				$player->sendMessage($this->caller->prefix."Oups.. Error has occured.. No gain found");
    				$event->setDrops([Item::get(0,0,0)]);
    				return;
    				}
    		}elseif($obj['Type'] ==  "Commands"){
    			$event->setDrops([Item::get(0,0,0)]);
    			$cmd = $obj['command'];
    			$cmd = str_replace(":nameofplayer:", $player->getName(), $cmd);
    			if ($obj['executor'] == "player") {
    				$this->caller->getServer()->dispatchCommand($player, $cmd);
    				$player->sendPopup($this->caller->prefix."executing command..");
    			}elseif ($obj['executor'] ==  "console") {
    				$this->caller->getServer()->dispatchCommand(new ConsoleCommandSender(), $cmd);
    				$player->sendPopup($this->caller->prefix."executing command..");
    			}else{
    				MN::$logger->warn('Usage of The type command in the case '.$nbchance.' but the executor is not player or command it\'s '.$obj['executor']);
    				$player->sendMessage($this->caller->prefix."Oups.. error has occured.. No gain found for Commands");
    			}
    			return;
    		}else{
    			$player->sendPopup($this->caller->prefix."§eSắp Nhận Được Quà Rồi :))");
    			$event->setDrops([Item::get(0,0,0)]);
    		}
    	}else return;
    }
}
