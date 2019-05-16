<?php
class DB {

	private $DB_HOST = "mysql-vincent-weber.alwaysdata.net";

	private $DB_NAME = "vincent-weber_projet_hotel";

	private $DB_USERNAME = "144459_bd_site";

	private $DB_PASSWORD = "connexionbdsite";

	public $db;

	public function __construct() {
		try {
			$db = new PDO("mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME, $this->DB_USERNAME, $this->DB_PASSWORD, array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			));
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db = $db;
		}
		catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

	}

	public static function select($query) {
		$res = (new static)
			->db
			->query($query);
			$res = $res->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}


	

	public static function quote($query) {
		$res = $this
			->db
			->quote($query);
		return str_replace("'", "", $res);
	}

	public static function insert($query){

		$db = (new static)->db;
		$res = $db
			->prepare($query);
		$res->execute();
		return $db->lastInsertId();;
	}

	public function update($query) {
		$db = (new static)->db;
		$res = $db
			->prepare($query);
		$res->execute();
	}

	public function delete($query) {
		$db = (new static)->db;
		$res = $db
			->prepare($query);
		$res->execute();
	}
}

