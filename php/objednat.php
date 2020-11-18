<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$user = $_SESSION['user'];

if (!loggedIn()) {
	header('Location: ../');
} else if (isset($_SESSION['cart'])){
	if (!empty($_SESSION['cart'])) {
		$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");
		$isPresent = true;
		$orderId = 0;
		$vals = array();
		$sql = '';

		while ($isPresent) {
			$orderId = date('ymd') . rand(0, 999);
			$isPresent = $db->query("SELECT * FROM objednavka WHERE id = ?", array($orderId))->fetch();
		}

		$sql .= 'INSERT INTO objednavka(id, user_id) VALUES (?, ?);';
		array_push($vals, $orderId, $user->getId());
		$sql .= 'INSERT INTO polozka(objednavka_id, zbozi_id, pocet, cena_za_kus) VALUES ';
		foreach ($_SESSION['cart'] as $k => $v) {
			$sql .= "(?, ?, ?, (SELECT price FROM zbozi WHERE id = ? LIMIT 1)), ";
			array_push($vals, $orderId, $k, $v['quantity'], $k);
		}

		$sql = substr($sql, 0, -2) . ';';

		$db->query($sql, $vals);

		unset($_SESSION['cart']);
		$_SESSION['cart'] = array();

		header("Location: ../order/?id=$orderId");

	} else {
		header('Location: ../eshop/');
	}
} else {
	header('Location: ../eshop/');
}

?>