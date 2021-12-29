<?php
declare(strict_types=1);
namespace jasonwynn10\VanillaEntityAI\entity\passive;

use jasonwynn10\VanillaEntityAI\entity\AnimalBase;
use jasonwynn10\VanillaEntityAI\entity\Collidable;
use jasonwynn10\VanillaEntityAI\entity\Interactable;
use jasonwynn10\VanillaEntityAI\entity\passiveaggressive\Player;
use pocketmine\entity\Entity;
use pocketmine\item\Item;

class Pig extends AnimalBase implements Collidable, Interactable {
	public const NETWORK_ID = self::PIG;
	public $width = 1.5;
	public $height = 1.0;

	public function initEntity() : void {
		$this->setMaxHealth(10);
		parent::initEntity();
	}

	/**
	 * @param int $tickDiff
	 *
	 * @return bool
	 */
	public function entityBaseTick(int $tickDiff = 1) : bool {
		return parent::entityBaseTick($tickDiff);
	}

	/**
	 * @return Item[]
	 */
	public function getDrops() : array {
		$drops = [];
		if($this->isOnFire()) {
			array_pad($drops, mt_rand(1, 3), Item::get(Item::COOKED_PORKCHOP));
		}else {
			array_pad($drops, mt_rand(1, 3), Item::get(Item::RAW_PORKCHOP));
		}
		if(!empty($this->getArmorInventory()->getContents())) {
			array_merge($drops, $this->getArmorInventory()->getContents());
		}
		return $drops;
	}

	public function getXpDropAmount() : int {
		//TODO: check for baby state
		return mt_rand(1, 3);
	}

	/**
	 * @return string
	 */
	public function getName() : string {
		return "Pig";
	}

	/**
	 * @param Entity $entity
	 */
	public function onCollideWithEntity(Entity $entity) : void {
		// TODO: Implement onCollideWithEntity() method.
	}

	public function onPlayerInteract(Player $player) : void {
		// TODO: Implement onPlayerInteract() method.
	}
}