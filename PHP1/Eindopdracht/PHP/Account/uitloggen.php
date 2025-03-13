<?php
// zorgt ervoor dat de gebruiker wordt uitgelogd
session_start();
session_unset();
session_destroy();
header("Location: ../../Index.php");
exit();
?>