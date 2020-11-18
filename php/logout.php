<?php if (empty(session_id())) {session_start();}; ?>
<?php

session_unset();
session_destroy();
header('Location: ../');

?>