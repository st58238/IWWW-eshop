<?php

class User {
	private $id;
	private $login;
	private $email;
	private $role;

	function __construct(int $id, string $login, string $email, int $role = 0) {
		$this->id = $id;
		$this->login = $login;
		$this->email = $email;
		$this->role = $role;
	}

	function getId(): int {
		return $this->id;
	}

	function getLogin(): string {
		return $this->login;
	}

	function getEmail(): string {
		return $this->email;
	}

	function getRole(): int {
		return $this->role;
	}

}

?>