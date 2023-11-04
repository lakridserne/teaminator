<?php
class config {
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    protected $path;

    public function __construct()
    {
        $this->path = __DIR__ . '/.env';
        $this->load_dotenv();
        $this->dbhost = getenv('DB_HOST');
        $this->dbuser = getenv('DB_USER');
        $this->dbpass = getenv('DB_PASS');
        $this->dbname = getenv('DB_NAME');
    }

    public function load_dotenv(): void
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

    public function get_dbname(): string
    {
        return $this->dbname;
    }

    public function get_dbhost(): string
    {
        return $this->dbhost;
    }

    public function get_dbuser(): string
    {
        return $this->dbuser;
    }

    public function get_dbpass(): string
    {
        return $this->dbpass;
    }
}
?>
