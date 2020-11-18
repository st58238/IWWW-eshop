<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];

if (!loggedIn()) {
	header('Location: ../');
} else if ($user->getRole() < 50) {
	header('Location: ../info/');
} else {
	$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

	$html .= '<table class="table_users"><tbody>';
	$html .= '<tr><th>ID</th><th>Login</th><th>Email</th><th>Role</th></tr>';
	$stmt = $db->query("SELECT id, login, email, role FROM users", array());

	foreach ($stmt as $k => $v) {
		$html .= "<tr>";
		foreach ($v as $key => $value) {
			$html .= "<td>$value</td>";
		}
		$html .= '<td><button onclick="location.href=&quot;myorders/?id=' . $v['id'] . '&quot;">Objednávky</button></td>';
		$html .= '<td><button onclick="location.href=&quot;info/?id=' . $v['id'] . '&quot;">Zobrazit</button></td>';
		$html .= '<td><button onclick="location.href=&quot;editace/?id=' . $v['id'] . '&quot;">Upravit</button></td>';
		$html .= "</tr>";
	}


	$html .= '</tbody></table>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<base href="../">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Správa uživatelů</title>
	<link rel="stylesheet" href="css/main.css">
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
