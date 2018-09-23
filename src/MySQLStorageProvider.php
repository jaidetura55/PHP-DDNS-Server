<?php

namespace yswery\DNS;

use \Exception;
use \Mysqli;

class MySQLStorageProvider extends AbstractStorageProvider {

	private $DS_TTL;
	private $cache = array();
	
	public function __construct(MySQLConfigProvider $config, $default_ttl = 60) {
		$c = new mysqli($config->host, $config->user, $config->password, $config->database);
		if (!$c)
			throw new Exception('Unable to establish MySQL connection');
		

		if (!is_int($default_ttl))
			throw new Exception('Default TTL must be an integer.');

		$this->DS_TTL = $default_ttl;
		
		$q = $c->query("SELECT * FROM NSEntry");
		while($t = $q->fetch_object())
			$this->cache[] = $t;
		
		$c->close();
	}
	
	private function query($domain, $type){
		$result = array();
		foreach($this->cache AS $t){
			if($t->NSEntryDomain == $domain AND $t->NSEntryType == $type)
				$result[] = $t;
		}
		
		return $result;
	}
	
	private function update(){
		$ip = msg_get_queue(3456);
		msg_receive($ip, 0, $msgtype, 5000, $message, true, MSG_IPC_NOWAIT, $err);
		if($msgtype == 8 AND $message != false){
			foreach($this->cache AS $t){
				if($t->NSEntryDomain == $message->domain){
					$t->NSEntryData = $message->ip;
					
					echo date("M d H:i:s").": updating $message->domain to $message->ip\n";
				}
			}
		}
	}
	
	public function get_answer($question) {
		$this->update();
		
		$answer = array();
		$domain = trim($question[0]['qname'], '.');
		$type = RecordTypeEnum::get_name($question[0]['qtype']);

		$q = $this->query($domain, $type);
		
		if ($type != 'SOA') {
			foreach($q AS $t){
				$ex = explode(",", $t->NSEntryData);
				foreach($ex AS $e)
					$answer[] = array(
						'name' => $question[0]['qname'], 
						'class' => $question[0]['qclass'],
						'ttl' => $this->DS_TTL, 
						'data' => array(
							'type' => $question[0]['qtype'],
							'value' => $e
							)
					);
				
			}
		} else {
			if(!count($q))
				return array(array(
				'name' => $question[0]['qname'], 
				'class' => $question[0]['qclass'],
				'ttl' => $this->DS_TTL, 
				'data' => array(
					'type' => $question[0]['qtype'], 
					'value' => array(
						"mname" => "", 
						"rname" => "", 
						"serial" => "20170319", 
						"retry" => "7200", 
						"refresh" => "1800", 
						"expire" => "8600", 
						"minimum-ttl" => "60")
					)
			));
			
			$ex = explode(",", $q[0]->NSEntryData);
			$r = array();
			foreach($ex AS $e){
				$sx = explode(":", $e);
				$r[$sx[0]] = $sx[1];
			}
			$answer[] = array(
				'name' => $question[0]['qname'], 
				'class' => $question[0]['qclass'],
				'ttl' => $this->DS_TTL, 
				'data' => array(
					'type' => $question[0]['qtype'], 
					'value' => $r
					)
			);
		}
		

		#$c->close();
		
		return $answer;
	}
	
}