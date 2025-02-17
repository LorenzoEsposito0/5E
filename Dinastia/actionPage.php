<?php
//superglobal variable -> $_POST (visible in all scripts)
echo $_GET['fname'];
echo $_GET['lname'];
setcookie('user', $_GET['fname']);
setcookie('user', $_GET['Color1']);

$colore = 'white';
?>
