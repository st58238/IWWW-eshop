<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];
$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

if (!loggedIn()) {
	header('Location: ../');
} else if ((isset($_GET['id']) && $user->getRole() > 50) || !isset($_GET['id'])) {
	$id = 0;
	if (isset($_GET['id'])) {
		$id = (int) htmlspecialchars($_GET['id']);
		$html .= '<section><h2>Objednávky</h2>';
	} else {
		$id = $user->getId();
		$html .= '<section><h2>Moje objednávky</h2>';
	}
	$stmt = $db->query("SELECT UNIX_TIMESTAMP(cas_objednani) AS cas, objednavka.id, COUNT(polozka.id) AS 'pocet', SUM(polozka.pocet * polozka.cena_za_kus) AS 'sum' FROM objednavka JOIN polozka ON polozka.objednavka_id = objednavka.id WHERE objednavka.user_id = ? GROUP BY 1 ORDER BY 1 DESC", array($id));
	$count = 0;
	

	foreach ($stmt as $k => $v) {
		$html .= '<div class="cart-item">
		<div class="cart-name">
		<a class="decorate" href="order/?id=' . $v['id'] . '">' . $v["id"] . '</a>
		</div>
		<div class="cart-control">
		<div class="cart-price">Celková cena: 
		' . number_format($v["sum"], 2, ",", "") . ' Kč
		</div>
		<div class="cart-quantity">Počet položek: 
		' . $v["pocet"] . ' položek
		</div>
		<div class="cart-quantity">Čas objednání: 
		' . str_replace(" ", "&nbsp;", date("j. n. Y G:i:s", (int) $v["cas"])) . '
		</div>
		</div>
		</div>';
		$count++;
	}
	$html .= '<div id="cart-total-price">Počet objednávek: ' . $count . '</div></section>';
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
	<title>Moje objednávky</title>
	<link rel="stylesheet" href="css/main.css">
	<style>
		.user > * {
			width: 80%;
		}

		.cart-name {
			padding-left: 14px;
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
