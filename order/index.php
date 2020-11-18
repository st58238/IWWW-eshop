<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];
$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

$stmt = $db->query("SELECT user_id, login FROM objednavka JOIN users ON objednavka.user_id = users.id WHERE objednavka.id = ?", array((int) htmlspecialchars($_GET['id'])));
$v = $stmt->fetch();
$userId = $v['user_id'];
$username = $v['login'];
unset($stmt);

if (!loggedIn()) {
	header('Location: ../');
} else if (isset($_GET['id']) && ($user->getRole() > 50 || $user->getId() == $userId)) {
	$sum = 0;
	$stmt = $db->query("SELECT name, img, cena_za_kus, pocet, objednavka_id FROM zbozi JOIN polozka ON polozka.zbozi_id = zbozi.id WHERE objednavka_id = ?;", array((int) htmlspecialchars($_GET['id'])));
	if ($user->getRole() > 50 && $user->getId() != $userId) {
		$html .= '<section><h2>Objednávka číslo ' . ((int) htmlspecialchars($_GET['id'])) . ' uživatele ' . $username . '</h2>';
	} else {
		$html .= '<section><h2>Objednávka číslo ' . ((int) htmlspecialchars($_GET['id'])) . '</h2>';
	}

	foreach ($stmt as $k => $v) {
		$orderId = 
		$html .= '<div class="cart-item">
		<div class="cart-img">
		' . $v["img"] . '
		</div>
		<div class="cart-name">
		' . $v["name"] . '
		</div>
		<div class="cart-control">
		<div class="cart-price">
		' . number_format($v["cena_za_kus"], 2, ",", "") . ' Kč/kus
		</div>
		<div class="cart-quantity">
		' . ($v["pocet"]);
		if ($v['pocet'] < 2) {
			$html .= " kus";
		} else if ($v['pocet'] < 6) {
			$html .= " kusy";
		} else {
			$html .= " kusů";
		}
		$html .= '
		</div>
		<div class="cart-quantity">
		' . number_format(($v["pocet"] * $v["cena_za_kus"]), 2, ",", "") . ' Kč,-
		</div>
		</div>
		</div>';
		$sum += ($v["pocet"] * $v["cena_za_kus"]);
	}
	$html .= '<div id="cart-total-price">Cena celkem: ' . number_format($sum, 2, ",", "") . ' Kč,-</div></section>';
	unset($stmt);
} else {
	header('Location: ../info/');
}

?>
<!DOCTYPE html>
<html>
<head>
	<base href="../">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Objednávka</title>
	<link rel="stylesheet" href="css/main.css">
	<style>
		.user > * {
			width: 80%;
		}
	</style>
</head>
<body>
	<div class="background"></div>
	<div class="main">
		<?php echo SIDEPANEL; ?>
		<div class="user">
			<?php echo $html; ?>
		</div>
	</div>
</body>
</html>
