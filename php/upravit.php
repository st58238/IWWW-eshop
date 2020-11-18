<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];

if (!loggedIn()) {
	header('Location: ../');
} else if (isset($_POST['ologin'])){
	$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

	$userDB = $db->query('SELECT * FROM users WHERE login = ?;', array(htmlspecialchars($_POST['ologin'])))->fetch();

	$id = $userDB['id'];

	if (isset($_POST['login'])) {
		if (!empty($_POST['login'])) {
			$res = $db->query('UPDATE users SET login = ? WHERE id = ?;', array(htmlspecialchars($_POST['login']), $id));
		}
	}
	if (isset($_POST['email'])) {
		if (!empty($_POST['email'])) {
			$db->query('UPDATE users SET email = ? WHERE id = ?;', array(htmlspecialchars($_POST['email']), $id));
		}
	}
	if (isset($_POST['pass'])) {
		if (!empty($_POST['pass'])) {
			$db->query('UPDATE users SET password = ? WHERE id = ?;', array(password_hash(htmlspecialchars($_POST['pass']), PASSWORD_BCRYPT, ["cost" => 13]), $id));
		}
	}

	if (isset($_POST['role'])) {
		if (!empty($_POST['role'])) {
			$db->query('UPDATE users SET role = ? WHERE id = ?;', array(htmlspecialchars($_POST['role']), $id));
		}
	}

	$stmt = $db->query("SELECT login, password, email, role FROM users WHERE id = ?;", array($id));
	$user = $stmt->fetch();

	if ($user == false) {
		header('Location: ../editace/?id=' . $id . '&failed=1');
	}

	header('Location: ../sprava/');
}

?>