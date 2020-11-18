<?php

class DB {
	private $conn;

	function __construct(string $driver, string $host, string $dbname, string $charset = "utf8", string $user, string $pass) {
		$dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";
		$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

		try {
			$this->conn = new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
			var_dump($e->getMessage());
		}

	}

	function __destruct() {
		unset($this->conn);
		$this->conn = null;
	}

	function query(string $query, array $vals) {
		$stmt = $this->conn->prepare($query);
		$stmt->execute($vals);
		return $stmt;
	}

}

?>