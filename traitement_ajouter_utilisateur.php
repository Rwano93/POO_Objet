<?php

include 'Main.php';

$user = new User($_POST['username'], $_POST['email'], $_POST['password']);
$user -> inscription();

?>
