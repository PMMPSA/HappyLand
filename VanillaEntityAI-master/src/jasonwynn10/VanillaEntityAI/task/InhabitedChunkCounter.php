<?php
declare(strict_types=1);
namespace jasonwynn10\VanillaEntityAI\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;

class InhabitedChunkCounter extends Task {
	public function onRun(int $currentTick) {
		foreach(Server::getInstance()->getLevels() as $level) {
			foreach($level->getPlayers() as $player) {
				$chunk = $player->chunk;
				if($chunk !== null) {
					if(!isset($chunk->inhabitedTime))
						$chunk->inhabitedTime = 1;
					else
						$chunk->inhabitedTime += 1;
				}
			}
		}
	}
}