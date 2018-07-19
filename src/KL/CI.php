<?php

namespace KL;

use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\{TextFormat, Config};
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\utils\TextFormat as TF;

class CI extends PluginBase implements Listener
{   
    
    public $formapi;
	public $pipol;
	
    public function onEnable()
    {

        $this->formapi = $this->getServer()->getPluginManager()->getPlugin('FormAPI');
        $this->getLogger()->info("Beautifying....");
		
        $this->particles = new particlesUI($this);
        $this->prefix = new prefixUI($this);
        $this->size = new sizeUI($this);
		$this->roles = new rolesUI($this);

        $this->saveResource('main.yml');
        $this->settings = new Config($this->getDataFolder() . "main.yml", CONFIG::YAML);
    }
	
    public function runCMD(string $c) : void
    {
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $c);
    }

    public function sendMainMenu(Player $player)
    {
        $form = $this->formapi->createSimpleForm(function (Player $player, array $data) {
            if (isset($data[0])){
                $button = $data[0];
                switch ($button)
                {
					case 0:
						$this->roles->mainForm($player);
							break;
                    case 1:	
						$this->size->mainForm($player);
							break;
                    case 2: 
						$this->prefix->mainForm($player);
							break;
					case 3:
						$this->particles->mainForm($player);
							break;
                    default:
							return;
                }

				return true;
            }
        });
        $form->setTitle('§l§fCosmetics');
		$form->addButton('§l§0Roles', 1, $this->settings->get('roles-image')); //data[0]
        $form->addButton('§l§0Size', 1, $this->settings->getNested('size.main')); //data[1]
        $form->addButton('§l§0Custom Names', 1, $this->settings->get('prefix')); //data[2]
		$form->addButton('§l§0Particles', 1, $this->settings->getNested('particles.main')); //data[3]
        $form->addButton('§l§0Exit'); //data[4]
        //$form->addButton('§l§eCapes', 1, $this->settings->getNested('store.image')); //data[3]

        $form->sendToPlayer($player);
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool
    {
	  	if(!$sender instanceof Player){
		  	$sender->sendMessage("Command must be run ingame!");
		 	return true;
	  	}

	  	switch(strtolower($cmd->getName())){
            case "cui": case "servercosmetics": case "++":
				$this->sendMainMenu($sender);
            break;
      }
        return true;
	}

}
