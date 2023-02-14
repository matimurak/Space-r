<!DOCTYPE html>

<html>
  <head>
    <title>Space-R - portal dla miłośników astronomii</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <?php include "genpur/js_scripts.php"; ?>
  </head>
  <body>
    <?php include "genpur/topbar.php"; ?>
    <div id="main">
      <div class="leftcolumn">
	<div id="calendar_js"></div>

	<script>
	    calendar_printWidget();
	</script>
      </div>
      <div class="twocolumn">
	<h2>Witamy na Space-R!</h2>
	<p>
	  Witamy na Space-R - portalu dla miłośników astronomii!<br>
	  Możesz <a href="user/login.php">zalogować się</a> i współtworzyć treści, lub eksplorować naszą 
	  <a href="blog/blogs.php">Przestrzeń</a> jako użytkownik niezalogowany.<br>
	  <br>
	  Twórz, dziel się, i przede wszystkim - odkrywaj!
	</p>
      </div>
    </div>
    <div class="footer">
      Mateusz Murak, 2023
    </div>
  </body>
</html>
