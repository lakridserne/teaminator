<?php
class config {
	private $host = getenv('HOST');
	private $user = getenv('USER');
	private $pass = getenv('PASS');
	private $db = getenv('DB');

	public function get_db() {
		return $this->db;
	}

	public function get_host() {
		return $this->host;
	}

	public function get_user() {
		return $this->user;
	}

	public function get_pass() {
		return $this->pass;
	}
}
?>
