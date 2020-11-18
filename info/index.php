<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$html = "";
$user = $_SESSION['user'];

if (!loggedIn()) {
	header('Location: ../');
} else if (!isset($_GET['id']) || $user->getRole() <= 50) {
	$html .= "<div class='picto'>";
	$html .= "<img src='img/picto.svg' alt='picto'>";
	$html .= "</div><div class='login'>";
	$html .= "<h2>Login</h2><h3>" . $user->getLogin() . "</h3>";
	$html .= "</div><div class='email'>";
	$html .= "<h2>Email</h2><h3>" . $user->getEmail() . "</h3>";
	$html .= "</div><div class='pass'>";
	$html .= "<h2>Heslo</h2><h3>Šifrováno</h3>";
	$html .= "</div>";
} else if (isset($_GET['id']) && $user->getRole() > 50) {
	$db = new DB("mysql", "localhost", "iwww-eshop", "utf8mb4", "root", "");

	$user = $db->query("SELECT id, login, email FROM users WHERE id = ?", array(htmlspecialchars($_GET['id'])))->fetch();

	$html .= "<div class='picto'>";
	$html .= "<img src='img/picto.svg' alt='picto'>";
	$html .= "</div><div class='login'>";
	$html .= "<h2>Login</h2><h3>" . $user['login'] . "</h3>";
	$html .= "</div><div class='email'>";
	$html .= "<h2>Email</h2><h3>" . $user['email'] . "</h3>";
	$html .= "</div><div class='pass'>";
	$html .= "<h2>Heslo</h2><h3>Šifrováno</h3>";
	$html .= "</div>";
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
