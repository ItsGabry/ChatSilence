<?php

namespace ItsGabry\ChatSilence;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\TextFormat;





class Main extends PluginBase implements Listener {

    private $nanotechs = false;


    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::RED . "nano techs pronta all'utilizzo");
        
    }


    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch (strtolower($command->getName())) {
            case "silence":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("silence.command")) {
                        if ($this->nanotechs == false) {
                            $this->nanotechs = true;
                            $sender->sendMessage(TextFormat::RED . "Hai attivato il silenzio globale");
                            $players = $sender->getServer()->getOnlinePlayers();
                            foreach ($players as $player) {
                                $player->addTitle(TextFormat::RED . "Silenzio globale attivo!");
                            }
                        } elseif($this->nanotechs == true) {
                            $sender->sendMessage(TextFormat::RED . "Il silenzio globale è già attivo");



                        }
                        return true;

                    }
                }
            case "unsilence":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("unsilence.command")) {
                        if ($this->nanotechs == true) {
                            $this->nanotechs = false;
                            $sender->sendMessage(TextFormat::RED . "Hai disattivato il silenzio globale");
                            $players = $sender->getServer()->getOnlinePlayers();
                            foreach ($players as $player) {
                                $player->addTitle(TextFormat::RED . "Silenzio globale disattivato!");
                            }
                        } elseif($this->nanotechs== false){
                            $sender->sendMessage(TextFormat::RED . "Nessun silenzio attivo trovato");



                        }
                        return true;

                    }

                }

        }
        return true;

    }

 public function nanoTechs(PlayerChatEvent $event) {
        if ($this->nanotechs) {
            if (!($event->getPlayer()->hasPermission("silence.bypass"))) {
                $event->setCancelled();
                $event->getPlayer()->sendMessage(TextFormat::GREEN . "Durante il silenzio globale non puoi scrivere!");
            }
        }
    }
}




#bo volevo arrivare a 100 righe