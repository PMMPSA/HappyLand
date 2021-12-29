<?php
declare(strict_types=1);
namespace jasonwynn10\VanillaEntityAI\task;

use jasonwynn10\VanillaEntityAI\entity\AnimalBase;
use jasonwynn10\VanillaEntityAI\entity\MonsterBase;
use pocketmine\level\format\Chunk;
use pocketmine\level\Level;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class DespawnTask extends Task {
	public function onRun(int $currentTick) {
		foreach(Server::getInstance()->getLevels() as $level) {
			/** @var Chunk[] $chunks */
			$chunks = [];
			foreach($level->getPlayers() as $player) {
				foreach($player->usedChunks as $hash => $sent) {
					if($sent) {
						Level::getXZ($hash, $chunkX, $chunkZ);
						$chunks[$hash] = $player->getLevel()->getChunk($chunkX, $chunkZ, true);
					}
				}
			}
			foreach($chunks as $chunk) {
				if(mt_rand(1, 50) !== 1) {
					continue;
				}
				foreach($chunk->getEntities() as $entity) {
					$distanceCheck = true;
					foreach($entity->getViewers() as $player) {
						if($entity->distance($player) < 54) {
							$distanceCheck = false;
							break;
						}
					}
					// TODO: check age
					if($entity instanceof MonsterBase and $distanceCheck and $entity->getLevel()->getFullLight($entity->floor()) > 8 and !$entity->isPersistent()) {
						$entity->flagForDespawn();
					}elseif($entity instanceof AnimalBase and $distanceCheck and $entity->getLevel()->getFullLight($entity->floor()) < 7 and !$entity->isPersistent()) {
						$entity->flagForDespawn();
					}
				}
			}
		}
	}
}