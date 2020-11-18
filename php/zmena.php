<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];

if (!loggedIn()) {
	header('Location: ../');
} else if (isset($_POST['cPass'])){
	$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

	$userDB = $db->query('SELECT * FROM users WHERE login = ?', array($user->getLogin()))->fetch();

	if ($userDB != false) {
		if (!password_verify(htmlspecialchars($_POST['cPass']), $userDB['password'])) {
			header('Location: ../zmena/?failed=1');
		}
	}
	if (isset($_POST['login'])) {
		if (!empty($_POST['login'])) {
			$db->query('UPDATE users SET login = ? WHERE id = ?', array(htmlspecialchars($_POST['login']), $userDB['id']));
		}
	}
	if (isset($_POST['email'])) {
		if (!empty($_POST['email'])) {
			$db->query('UPDATE users SET email = ? WHERE id = ?', array(htmlspecialchars($_POST['email']), $userDB['id']));
		}
	}
	if (isset($_POST['pass'])) {
		if (!empty($_POST['pass'])) {
			$db->query('UPDATE users SET password = ? WHERE id = ?', array(password_hash(htmlspecialchars($_POST['pass']), PASSWORD_BCRYPT, ["cost" => 13]), $userDB['id']));
		}
	}

	$stmt = $db->query("SELECT login, password, email, role FROM users WHERE id = ?", array($userDB['id']));
	$user = $stmt->fetch();

	if ($user == false) {
		header('Location: ../zmena/?failed=1');
	}
	$user = new User($user['id'], $user['login'], $user['email'], $user['role']);
	$_SESSION['user'] = $user;

	header('Location: ../zmena/?failed=0');
}

?>