<?php
include "../genpur/get_userdata.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $loggedin = true;
} else {
    $loggedin = false;
}
if( ! $loggedin) header("location: ../index.php");

$userdata = get_userdata();
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Space-R - portal dla miłośników astronomii</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
  </head>
  <body>
    <?php include "../genpur/topbar.php"; ?>
    <div id="main">
      <div class="onecolumn">
	
	<h2>Ustawienia konta</h2>
	
	<h3>Twoje dane</h3>
	<div id="disp-fname" class ="dispctrl">
	  Nazwa użytkownika: <b><?php echo $userdata['username'];?></b>
	</div>
	<div id="disp-fname" class ="dispctrl">
	  Imię: <b><?php echo $userdata['fname'];?></b>
	</div>
	<div id="disp-lname" class ="dispctrl">
	  Nazwisko: <b><?php echo $userdata['lname'];?></b>
	</div>
	<div id="disp-status" class ="dispctrl">
	  Uprawnienia: <b><?php
	  if($userdata['admin']) 
	      echo '**Administrator**';
	  elseif($userdata['moderator'])
	      echo '*Moderator*';
	  else
	      echo 'brak';
	  ?></b>
	</div>
	
	<h3>Zmień dane</h3>
	<p>Uzupełnij pola z danymi, które chcesz zmienić. Pozostałe pola pozostaw
	  puste.</p>
	
	<form action="account_process.php" method="post">
	  <div id="form-uname" class="formctrl">
	    <label>Nazwa użytkownika</label>
	    <input type="text" name="username" 
		   placeholder="Twoja nowa nazwa użytkownika">
	  </div>
	  <div id="form-fname" class="formctrl">
	    <label>Imię</label>
	    <input type="text" name="fname" placeholder="Twoje imię">
	  </div>
	  <div id="form-lname" class="formctrl">
	    <label>Nazwisko</label>
	    <input type="text" name="lname" placeholder="Twoje nazwisko">
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
	    <input type="submit" value="Aktualizuj"></input>
	  </div>
	</form>
	
      </div>
    </div>
  </body>
</html>