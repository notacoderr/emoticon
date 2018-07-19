<?php

namespace KL;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as TF;

class EI extends PluginBase implements Listener
{   
    
    public $formapi;
	
    public function onEnable()
    {
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin('FormAPI');
        $this->getLogger()->info("Enabling...");
    }
	
    private function Announce(string $c) : void
    {
        $this->getServer()->broadcast($c);
    }

    public function sendMainMenu(Player $player)
    {
        $form = $this->formapi->createSimpleForm(function (Player $player, array $data) {
        if (isset($data[0])){
		$button = $data[0];
		$emoticon = $this->getEmotes()[$button];
		$this->Announce("• " . TF::BOLD . TF::AQUA . $player->getDisplayName() . TF::RESET . TF::BLACK . " >§c " . $emoticon);
	}
		
	});
		
        $form->setTitle('§l§fEMOTES');
	foreach($this->getEmotes() as $emote)
	{
		$form->addButton('§l§0' . $emote);
	}
        $form->sendToPlayer($player);
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool
    {
	  	if(!$sender instanceof Player)
		{
			$sender->sendMessage("Command must be run ingame!");
			return true;
	  	}

	  	switch( strtolower ( $cmd->getName() ))
		{
				
            		case "ei": case "\":
				$this->sendMainMenu($sender);
           		break;
      		}
	    return true;
    }
   
    public function getEmotes() : array
    {
   	$emotes = array(
			"( ͡° ͜ʖ ͡°)", "∠( ᐛ 」∠)＿", "(ﾟ⊿ﾟ)", "ᕕ( ᐛ )ᕗ", "_へ__(‾◡◝ )>",
			"(/^▽^)/", "( ᐛ )و", "( ´ ▽ ` )ﾉ", "(´∇ﾉ｀*)ノ", "⁽ˇ́˙̫ˇ̀˵⁾", "(◡‿◡✿)", "✌(-‿-)✌",
			"┌∩┐(ಠ_ಠ)┌∩┐", "(；¬д¬)", "(⁎˃ᆺ˂)", "( ｰ̀εｰ́ )", "(꒪⌓꒪)", "(ーー;)", "(*´﹃｀*)",
			"(º﹃º )", "ɖී؀ීϸ", "＼(-_- )", "(￣^￣)ゞ", "ʕ•͡ɛ•͡ʼʼʔ", "(๑ↀᆺↀ๑)", "(.﹒︣︿﹒︣.)",
			"(´-ι_-｀)"
			);
	return $emotes;
    }

}
