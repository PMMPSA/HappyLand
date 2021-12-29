<?php



namespace soradore\ai;


/* Base */
use pocketmine\plugin\PluginBase;

/* Events */
use pocketmine\event\Listener;


/* Level and Math */
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

use pocketmine\entity\Entity;
use pocketmine\utils\Config;

use soradore\ai\Task\ZombieTask;
use soradore\ai\Task\SpawnTask;
use soradore\ai\CustomEntities\CustomZombie;

class main extends PluginBase implements Listener{

    public static $entityCount = 0;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->id = [];

        $task = new SpawnTask($this);
        $this->getScheduler()->scheduleRepeatingTask($task, 20*60*2);
        if(!file_exists($this->getDataFolder())){
            mkdir($this->getDataFolder(), 0744);
        }

        $this->setting = new Config($this->getDataFolder() . "setting.yml", Config::YAML,
                                   [
                                    "ignition_in_the_day"=>false,
                                    ]);
    }

    public function onDamage(\pocketmine\event\entity\EntityDamageEvent $ev){
        $entity = $ev->getEntity();
        if($entity instanceof \pocketmine\entity\Zombie && $ev instanceof \pocketmine\event\entity\EntityDamageByEntityEvent){
            $id = $entity->getId();
            if(!isset($this->id[$id])){
                $zombie = new CustomZombie($entity, null, rand(1, 4));
                $task = new ZombieTask($this, $zombie);
                $this->getScheduler()->scheduleRepeatingTask($task, 1);
                $this->id[$id] = $task;
            }else{
                $this->id[$id]->setMove(false);
            }
            //$ev->setKnockBack(0);

        }
    }

    public function onDeath(\pocketmine\event\entity\EntityDeathEvent $ev){
        $entity = $ev->getEntity();
        $id = $entity->getId();
        if(isset($this->id[$id])){
            $this->getScheduler()->cancelTask($this->id[$id]->getTaskId());
            unset($this->id[$id]);
            self::$entityCount--;
        }
    }



    public function onPlayerDeath(\pocketmine\event\player\PlayerDeathEvent $ev){
        $ev->setDeathMessage("");
    }


    public function addEntity(){
        self::$entityCount++;
    }

    public function getEntityCount(){
        return self::$entityCount;
    }
}

