<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<h1>Benvenuto <?php echo $_SESSION['username'].'<br>'; echo 'sei uno:'; echo $_SESSION['status']?></h1>
