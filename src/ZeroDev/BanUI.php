<?php 

namespace ZeroDev;

use pocketmine\Player;

use pocketmine\utils\TextFormat as T;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\command\defaults\VanillaCommand;

class BanUI extends VanillaCommand {
    
  private $plugin;

  public function __construct(\ZeroDev\Main $plugin){
    $this->plugin = $plugin;
    parent::__construct('TransferUI', 'Transfer servers with a UI', '/trui');
    $this->setPermission('plugins.command');
  }

  public function execute(CommandSender $sender, $alias, array $args){
  if($sender instanceof Player){
    $ui = new \ZeroDev\UI\SimpleUI(25530);
    $ui->addTitle(T::AQUA ."Transfer Servers ". T::YELLOW . $this->plugin->ver);
    $ui->addContent(T::AQUA ."Choose an action!");
    $ui->addButton("Transfer to HimbeerCraft", -1);
    $ui->addButton("Get Some Info", -1);
    $ui->addButton("Cancel.", -1);
    $ui->send($sender);
    return true;
  } else {
    $sender->sendMessage(T::RED."Command must be run in-game!");
    return false;     
   }
  }
}
