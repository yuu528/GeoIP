<?php

namespace yuu528;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

class GeoIP extends PluginBase
{
    public function onLoad()
	{
		$this->getServer()->getLogger()->info("[GeoIP] ロード");
	}

	public function onEnable()
	{
		$this->getServer()->getLogger()->info("[GeoIP] 有効");
    }

	public function onDisable()
	{
		$this->getServer()->getLogger()->info("[GeoIP] 無効");
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		switch(strtolower($command->getName())){
			case "geoip":
				if(!isset($args[0])) return false;

				$players = Server::getInstance()->getOnlinePlayers();
				foreach ($players as $player) {
					$name = $player->getName();
					if($args[0] === $name){
						$ip = $player->getAddress();
						$ipdata = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
						if ($ipdata['status'] === "fail"){
							$sender->sendMessage("[GeoIP] §cエラーが発生しました。");
							$sender->sendMessage(" - 原因:　{$ipdata['message']}");
							return true;
							break;
						}
						$host = gethostbyaddr($ip);
						$sender->sendMessage("[GeoIP] §c(*のついている情報は間違いがある可能性があります)");
						$sender->sendMessage(" - IP: {$ip}\n - ホスト名: {$host}\n - 国: {$ipdata['country']}\n - 県: {$ipdata['regionName']}\n - 市*: {$ipdata['city']}\n - 緯度*: {$ipdata['lat']}\n - 経度*: {$ipdata['lon']}\n - タイムゾーン: {$ipdata['timezone']}\n - ISP(プロバイダ): {$ipdata['isp']}");
						return true;
						break;
					}
				}
				$ipdata = json_decode(file_get_contents("http://ip-api.com/json/{$args[0]}"), true);
				if ($ipdata['status'] === "fail"){
					$sender->sendMessage("[GeoIP] §cエラーが発生しました。");
					$sender->sendMessage(" - 原因:　{$ipdata['message']}");
					return true;
					break;
				}
				if(preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $args[0])){
					$host = gethostbyaddr($args[0]);
				}else{
					$host = $args[0];
				}

				$sender->sendMessage("[GeoIP] §c(*のついている情報は間違いがある可能性があります)");
				$sender->sendMessage(" - IP: {$args[0]}\n - ホスト名: {$host}\n - 国: {$ipdata['country']}\n - 県: {$ipdata['regionName']}\n - 市*: {$ipdata['city']}\n - 緯度*: {$ipdata['lat']}\n - 経度*: {$ipdata['lon']}\n - タイムゾーン: {$ipdata['timezone']}\n - ISP(プロバイダ): {$ipdata['isp']}");
				return true;
				break;
		}
	}
}
