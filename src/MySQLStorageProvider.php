<?php

namespace yswery\DNS;

use \Exception;
use \Mysqli;

class MySQLStorageProvider extends AbstractStorageProvider {

	private $DS_TTL;
	private $data;

	public function __construct($host, $user, $password, $database, $default_ttl = 60) {
		$this->c = new mysqli($host, $user, $password, $database);
		if (!$this->c)
			throw new Exception('Unable to establish MySQL connection');
		$this->c->close();

		$this->data = array("host" => $host, "user" => $user, "password" => $password, "database" => $database);

		if (!is_int($default_ttl))
			throw new Exception('Default TTL must be an integer.');

		$this->DS_TTL = $default_ttl;
	}

	public function get_answer($question) {
		$answer = array();
		$domain = trim($question[0]['qname'], '.');
		$type = RecordTypeEnum::get_name($question[0]['qtype']);

		$c = new mysqli($this->data["host"], $this->data["user"], $this->data["password"], $this->data["database"]);
		if (!$c)
			throw new Exception('Unable to establish MySQL connection');
		
		$q = $c->query("SELECT * FROM NSEntry WHERE NSEntryDomain = '".  $c->real_escape_string($domain)."' AND NSEntryType = '".$c->real_escape_string($type)."'");
		
		if ($type != 'SOA') {
			while($t = $q->fetch_object()){
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
			$t = $q->fetch_object();
			$ex = explode(",", $t->NSEntryData);
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
		

		$c->close();
		
		return $answer;
	}
	
}
