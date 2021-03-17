<?php
namespace noahasu\score;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use noahasu\score\ScoreBoard;
use onebone\economyjob\EconomyJob;

class Main extends PluginBase implements Listener {
    public $scoreText;
    public $economyJob;
    public function onEnable() {
        $this -> getServer() -> getPluginManager() -> registerEvents($this,$this);
        $this->economyJob = $this->getServer()->getPluginManager()->getPlugin("EconomyJob");
        $this ->scoreText = new Config($this -> getDataFolder()."scoretext.yml",Config::YAML,array(
            '所持金: %money' => 1,
            '現在のmiLevel: %level' => 2,
            '次のレベルまで: %upexpexp' => 3,
            '座標: %xyz' => 4,
            '現在の時刻: %time' => 5,
            'id: %id' => 6,
            'アイテム名: %name' => 7,
            'オンライン人数: %online' => 8,
            '職業: %job' => 9
        ));
        $this -> getScheduler() -> scheduleRepeatingTask(new ScoreBoard($this),5);
        date_default_timezone_set('Asia/Tokyo');
    }

    public function getJob(String $playerName): ?String{
        return $this->economyJob->getPlayers()[$playerName] ?? null;
    }
}
