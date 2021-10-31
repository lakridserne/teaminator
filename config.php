<?php
class config {
	private $host = env('HOST', 'localhost');
	private $user = env('USER', 'user');
	private $pass = env('PASS', 'password');
	private $db = env('DB', 'database');

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
