<?php if (!isset($_SESSION)) session_start(); ?>

<!DOCTYPE html>

<html>
  <head>
    <title>Kalendarz</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <style>
      #cal_wg_table {display:table;}
      #cal_showbutton, #cal_hidebutton {display:none;}
    </style>
    
    <script> 
	let isSidebar = false;
    </script>
    <?php include "../genpur/set_uservars.php"; ?>
    <?php include "../genpur/js_scripts.php"; ?>
    <script src="http://localhost/space-r/calendar/eventdetails.js"></script>
  </head>
  <body>
    <?php include "../genpur/topbar.php"; ?>
    
    <div id="main">
      
      <div class="onecolumn">
    
	<h1>Kalendarz</h1>
	
	<div id="calendar_js"></div>
	<script>
	    calendar_printWidget();
	</script>
	
	<div class="buttonbar">
	  <?php 
	  if(isset($_SESSION['moderator']) && $_SESSION['moderator']) 
	      include 'buttonbar.php';
	  ?>
	</div>
	
	<div id="switch_content">
	  <div id="newev_form_widget">
	      <?php 
	      if(isset($_SESSION['moderator']) && $_SESSION['moderator']) 
		  include "newevent_form.php";		
	      ?>
	  </div>
	  <div id="evdetails_widget"></div>
	</div>

      </div>
      <div class="footer">
	Mateusz Murak, 2023
      </div>
    </div>
  </body>
</html>
    