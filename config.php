<?php
class config {
	private $host = "localhost";
	private $user = "user";
	private $pass = "password";
	private $db = "database";

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
