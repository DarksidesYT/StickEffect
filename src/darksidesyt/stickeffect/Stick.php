<?php
namespace plugin\stickeffect;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use plugin\stickeffect\event\StickListener;

class Stick extends PluginBase
{
    public static $instance;

    public static function getStick(): Stick
    {
        return self::$instance;
    }

    public function onEnable()
    {
        if (!$this->getConfig()->exists('version')) {
            rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'old_config.yml');
            $this->saveResource('config.yml');
            $this->getLogger()->warning('Config.yml is a lower version, config.yml to -> old_config.yml and new config.yml is saved.');
        }elseif ($this->getConfig()->get('version') !== 1.0){
            rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'old_config.yml');
            $this->saveResource('config.yml');
            $this->getLogger()->warning('Config.yml is a lower version, config.yml to -> old_config.yml and new config.yml is saved.');
        }
        self::$instance = $this;
        Server::getInstance()->getPluginManager()->registerEvents(new StickListener(), $this);
    }





    public function getAllStick(): array{
        return $this->getConfig()->getAll();
    }
    public function getStickFromString(string $string): array{
        return $this->getConfig()->get($string);
    }


    public function getAllEffectFromStick(string $string): array{
        return $this->getConfig()->get($string)['effect'];
    }


    public function hasPermInStick(string $stick): bool{
        if (array_key_exists('permission', $this->getConfig()->get($stick))){
            if ($this->getConfig()->get($stick)['permission']['enable']) return true;
        }
        return false;
    }


    public function getPermissionInStick(string $stick): string{
        return $this->getConfig()->get($stick)['permission']['perm'];
    }
}
