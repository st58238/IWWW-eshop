<?php require_once('../php/user.class.php'); require_once('../php/database.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php
$user;
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}

$sidepanel = '
<div class="sidepanel">
	<div class="row">
		<h1>CRUD</h1>
	</div>
	<div class="row">
		<p>
			<a href="info">Informace o&nbsp;uživateli</a>
		</p>
	</div>
	<div class="row">
		<p>
			<a href="zmena/">Změna údajů</a>
		</p>
	</div>
		<div class="row">
		<p>
			<a href="eshop">Eshop</a>
		</p>
	</div>
	<div class="row">
		<p>
			<a href="kosik">Košík</a>
		</p>
	</div>
	<div class="row">
		<p>
			<a href="myorders">Moje objednávky</a>
		</p>
	</div>';
	if (isset($user)) {
		if ($user->getRole() > 50) {
			$sidepanel .= '<div class="row"><p><a href="sprava/">Správa uživatelů</a></p></div>';
			$sidepanel .= '	<div class="row"><p><a href="allorders">Všechny objednávky</a></p></div>';
		}
	}
$sidepanel .= '
	<div class="row">
		<p>
			<a href="php/logout.php">Odhlásit</a>
		</p>
	</div>
</div>
';
define("SIDEPANEL", $sidepanel);

?>