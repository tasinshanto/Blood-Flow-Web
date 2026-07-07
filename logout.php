<?php
session_start(); // Session start kora juri session remove korar jonno
session_unset(); // Shob session variables khali kora
session_destroy(); // Session pura puri dhongsho kora

// Logout hoye gele Dashboard ba Login page-e redirect kora
header("Location: deshbord.php");
exit();
?>