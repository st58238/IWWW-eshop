<?php if (empty(session_id())) {session_start();}; ?>
<?php

if (isset($_SESSION['user'])) {
	header('Location: info/');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Správa uživatelů</title>
	<link rel="stylesheet" href="css/main.css">
	<script defer="defer">
		document.addEventListener("DOMContentLoaded", function(){
			document.querySelector("#regButton").addEventListener("click", function(e){
				document.location.href = "registrace";
			});

			let url = window.location;
			if (url.toString().includes("?")) {
				if (url.toString().split("?")[1].split("=")[1] == "1") {
					alert("Nesprávná kombinace Loginu a hesla.");
				}
			}
		});
	</script>
</head>
<body>
	<div class="background"></div>
	<form class="form_full_center" action="php/login.php" method="post">
		<div class="login_form">
			<input type="text" name="login" class="form_input" placeholder="Login">
			<input type="password" name="pass" class="form_input" placeholder="Heslo">
			<button type="button" id="regButton">Registrace</button>
			<input type="submit" class="form_input" value="Přihlásit">
		</div>
	</form>
</body>
</html>
