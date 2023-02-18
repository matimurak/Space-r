<!DOCTYPE html>

<?php
session_start();

$_SESSION = array();
session_destroy();
?>

<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <title>Wylogowano</title>
  </head>
  <body>
    <?php include "../genpur/topbar.php"; ?>
    
    <div id="main">
      <div class="onecolumn">
	<h2>Wylogowano</h2>
	<p>
	  Możesz teraz <a href="../user/login.php">zalogować się</a><br>
	  lub wrócić na <a href="../index.php">stronę główną</a>.
	</p>
      </div>
    <div class="footer">
      Mateusz Murak, 2023
    </div>
  </body>
</html>
