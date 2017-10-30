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
    parent::__construct('banui', 'allows admins to ban/unban players with a gui', '/banui');
    $this->setPermission('plugins.command');
  }

  public function execute(CommandSender $sender, $alias, array $args){
  if($sender instanceof Player){
    $ui = new \Plexus\utils\UI\SimpleUI(25530);
    $ui->addTitle(T::AQUA ."BanUI ". T::YELLOW . $this->plugin->ver);
    $ui->addContent(T::AQUA ."What Would You Like to Do?");
    $ui->addButton("Ban.", -1);
    $ui->addButton("Pardon.", -1);
    $ui->addButton("Cancel.", -1);
    $ui->send($sender);
    return true;
  } else {
    $sender->sendMessage(T::RED."Command must be run in-game!");
    return false;     
   }
  }
}