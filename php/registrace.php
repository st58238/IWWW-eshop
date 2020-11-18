<?php if (empty(session_id())) {session_start();}; ?>
<?php

require_once('user.class.php');
require_once('database.php');

if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['email'])) {
	$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");
	
	$login = htmlspecialchars($_POST['login']);
	$pass = htmlspecialchars($_POST['pass']);
	$email = htmlspecialchars($_POST['email']);

	$loginPassed = $db->query('SELECT * FROM users WHERE login = ?', array($login))->fetch();
	$emailPassed = $db->query('SELECT * FROM users WHERE email = ?', array($email))->fetch();

	if ($loginPassed == false && $emailPassed == false) {
		$res = $db->query('INSERT INTO users(login, password, email) VALUES(?, ?, ?)', array($login, password_hash($pass, PASSWORD_BCRYPT, ["cost" => 13]), $email));
	} else if($loginPassed != false) {
		header('Location: ../registrace?failed=login');
	} else if($emailPassed != false) {
		header('Location: ../registrace?failed=email');
	}

	$stmt = $db->query("SELECT id, login, password, email, role FROM users WHERE login = ?", array($login));
	$user = $stmt->fetch();

	$user = new User($user['id'], $user['login'], $user['email'], $user['role']);
	$_SESSION['user'] = $user;

	header('Location: ../info/');
} else {
	header('Location: ../registrace');
}

?>