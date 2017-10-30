<?php

namespace ZeroDev;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as T;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

class Main extends PluginBase implements Listener {

  public $countiu = 25530;
  public $ver = "v1.0.0-beta";

  public $bp = [];
  public $ptb = [];
  public $bid = 1;

  public function onEnable(){
    $this->getLogger()->info(T::YELLOW ."Loading...");
 try {
  $this->getServer()->getPluginManager()->registerEvents($this, $this);
  $this->getServer()->getCommandMap()->register('banui', new \ZeroDev\BanUI($this));

    //@mkdir($this->getDataFolder());
    //$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

    $this->getLogger()->info(T::YELLOW ."has Loaded successfully!");
  } 
   catch(Exception $e){
    $this->getLogger()->info(T::RED ."Plugin has Failed to Load due to $e"); 
   }
  }

  public function onPacketReceived(\pocketmine\event\server\DataPacketReceiveEvent $e){
    $player = $e->getPlayer();
    $pk = $e->getPacket();
  if($pk instanceof ModalFormResponsePacket){
    $id = $pk->formId;
    $button = json_decode($pk->formData, true);
  if($id === 25530){
    $this->banui($player, $button);
    
  }
  if($id === 25531){
    $this->banlist($player, $button);
  }
  if($id === 25532){
    $this->bancheck($player, $button);
    }
   }
  }

  public function banui($player, $buttonid){
  if($buttonid === 0){
    $ui = new \Plexus\utils\UI\SimpleUI(25531);
    $ui->addTitle(T::AQUA ."Transfer to Server". T::YELLOW . $this->ver);
    $ui->addContent(T::AQUA ."Click a player you want to ban\n\nto update the list click Update\n\n");
    $onlineP = $this->getServer()->getOnlinePlayers();
    $ui->addButton("Update", -1);
  foreach($onlineP as $p){
    $ui->addButton("Ban: ". T::RED . $p->getName(), -1);
    $this->bp[$this->bid] = $p;
    $this->bid++;
  }
    $ui->send($player);
   } 
  } 

  public function banlist($player, $buttonid){
  if($buttonid != 0){
  if(isset($this->bp[$buttonid])){
    $p = $this->bp[$buttonid];
  if($p->isOp() === false){
    $ui = new \Plexus\utils\UI\SimpleUI(25532);
    $ui->addTitle(T::AQUA ."BanUI ". T::YELLOW . $this->ver);
    $ui->addContent(T::AQUA ."Are you sure you want to ban ". $p->getName() ."?\n\n");
    $ui->addButton("Yes", -1);
    $ui->addButton("No", -1);
    $this->ptb[$player->getName()] = $p;
    $ui->send($player);
  } else {
    $ui = new \Plexus\utils\UI\SimpleUI(25533);
    $ui->addTitle(T::AQUA ."BanUI ". T::YELLOW . $this->ver);
    $ui->addContent(T::AQUA ."You can't ban other admins silly.\n\n");
    $ui->addButton("Ok.", -1);
    $ui->send($player);
     }
    }  
   } elseif($buttonid === 0) {
    $this->banui($player, 0);
   }
  }

  public function bancheck($player, $buttonid){
  if($buttonid === 0){
    $p = $this->ptb[$player->getName()];
    $p->setBanned(true);
    $ui = new \Plexus\utils\UI\SimpleUI(25534);
    $ui->addTitle(T::AQUA ."BanUI ". T::YELLOW . $this->ver);
    $ui->addContent(T::RED ."You Banned ". $p->getName() ."!\n\n");
    $ui->addButton("Ok.", -1);
    $ui->send($player);
   }
  }
}
