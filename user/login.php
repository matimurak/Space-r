<!DOCTYPE html>
<?php 
session_start(); 

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}
?>

<html>
  <head>
    <title>Logowanie</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
  </head>

  <body>
    <?php include "../genpur/topbar.php"; ?>
    
    <div id="main">
      <div class="onecolumn">
	
	<h2>Zaloguj się</h2>
	
	<div class="formwarn">
	  <?php
	  if( ! empty($_GET["errormsg"])) {
	      echo htmlspecialchars($_GET["errormsg"]);
	  }
	  ?>
	</div>
	
	<form action="login_process.php" method="post">
	  <div id="form-uname" class="formctrl">
	    <label>Nazwa użytkownika</label>
	    <input type="text" name="username" placeholder="Wprowadź nazwę">
	  </div>
	  <div id="form-passwd" class="formctrl">
	    <label>Hasło</label>
	    <input type="password" name="password" placeholder="Wprowadź hasło">
	  </div>
	  <div id="submitbutton" class="formctrl">
	    <input type="submit" value="Zaloguj"></input>
 	  </div>
	</form>
	
      </div>
    </div>
  </body>
</html>