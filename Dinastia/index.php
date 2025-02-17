<?php
$name= $_COOKIE['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>test superglobal</title>
</head>
<body>
<!--default method is get-->
<h1>ciao <?php echo $name?></h1>
<form action="actionPage.php">
    <label for="fname">First name:</label><br>
    <input type="text" id="fname" name="fname"><br>
    <label for="Color1">Color1:</label><br>
    <input type="text" id="lname" name="color1"><br>
    <label for="Color2">Color2:</label><br>
    <input type="text" id="col1" name="color2"><br>
    <label for="color3">Color3:</label><br>
    <input type="text" id="col2" name="color3"><br>
    <br>
    <input type="submit">
</form>
</body>
</html>