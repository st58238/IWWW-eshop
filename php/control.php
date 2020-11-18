<?php if (empty(session_id())) {session_start();}; ?>
<?php

function loggedIn(): bool {
	return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

?>