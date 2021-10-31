<?php
class config {
	private $host;
	private $user;
	private $pass;
	private $db;

	public function __construct()
	{
		$this->host = getenv('HOST');
		$this->user = getenv('USER');
		$this->pass = getenv('PASS');
		$this->db = getenv('DB');
	}

	public function get_db()
	{
		return $this->db;
	}

	public function get_host()
	{
		return $this->host;
	}

	public function get_user()
	{
		return $this->user;
	}

	public function get_pass()
	{
		return $this->pass;
	}
}
?>
