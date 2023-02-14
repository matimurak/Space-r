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
    <title>Rejestracja</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
  </head>
  <body>
    <?php include "../genpur/topbar.php"; ?>
    
    <div id="main">
      <div class="onecolumn">
	
	<h2>Zarejestruj się</h2>
	
	<div class="formwarn">
	  <?php
	  if( ! empty($_GET["errormsg"])) {
	      echo htmlspecialchars($_GET["errormsg"]);
	  }
	  ?>
	</div>
	
	<form action="signin_process.php" method="post">
	  <div id="form-fname" class="formctrl">
	    <label>Imię</label>
	    <input type="text" name="fname" placeholder="Twoje imię">
	  </div>
	  <div id="form-lname" class="formctrl">
	    <label>Nazwisko</label>
	    <input type="text" name="lname" placeholder="Twoje nazwisko">
	  </div>
	  <div id="form-uname" class="formctrl">
	    <label>Nazwa użytkownika</label>
	    <input type="text" name="username" 
		   placeholder="Tak będą Cię widzieć inni użytkownicy">
		   <!--
		   class="form-control <?php
		      //echo (empty(username_err)) ? '' : 'is-invalid';
		   ?>" -->
	  </div>
	  <div id="form-passwd" class="formctrl">
	    <label>Hasło</label>
	    <input type="password" name="password" placeholder="Twoje hasło">
	    <div class="formhelp">Nie używaj haseł z innych usług!</div>
	  </div>
	  <div id="form-conf_passwd" class="formctrl">
	    <label>Potwierdź hasło:</label>
	    <input type="password" name="conf_password" placeholder="Potwierdź hasło">
	  </div>
	  <div id="submitbutton" class="formctrl">
	    <input type="submit" value="Rejestruj"></input>
	  </div>
	</form>
	
      </div>
    </div>
    
    <div class="footer">
      Mateusz Murak, 2023
    </div>
  </body>
</html>