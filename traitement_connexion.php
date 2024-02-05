<?php

include 'Main.php';

$user = new User($_POST['username'], $_POST['password']);
$user -> connexion();
