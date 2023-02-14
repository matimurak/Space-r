<?php if (!isset($_SESSION)) session_start(); ?>

<!DOCTYPE html>

<html>
  <head>
    <title>Space-R - portal dla miłośników astronomii</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <?php include "../genpur/js_scripts.php"; ?>
    <?php include "../genpur/set_uservars.php"; ?>
  </head>
  <body>
    <?php include "../genpur/topbar.php"; ?>
    
    <div id="main">
      
      <div class="leftcolumn">
	<div id="calendar_js"></div>
	<script>
	    calendar_printWidget();
	</script>
      </div>
      
      <div class="twocolumn">
	<h2>Blog</h2>
	<p>
	  Znajdujesz się w strefie blogów. <br>
	  Przeglądaj istniejące blogi, lub załóż własny!
	</p>
      </div>
      
    </div>
    
    <div class="footer">
      Mateusz Murak, 2023
    </div>
  </body>
</html>
