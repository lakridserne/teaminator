<?php
class config {
	private $host;
	private $dbuser;
	private $pass;
	private $db;
	protected $path;

	public function __construct()
	{
		$this->path = __DIR__ . '/.env';
		$this->load_dotenv();
		$this->host = getenv('HOST');
		$this->dbuser = getenv('DB_USER');
		$this->pass = getenv('PASS');
		$this->db = getenv('DB');
	}

	public function load_dotenv()
	{
		if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
	}

	public function get_db()
	{
		return $this->db;
	}

	public function get_host()
	{
		return $this->host;
	}

	public function get_dbuser()
	{
		return $this->dbuser;
	}

	public function get_pass()
	{
		return $this->pass;
	}
}
?>
