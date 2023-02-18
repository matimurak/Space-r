<?php 
// This php file contains logo and top menu bar.
// It is meant to be included into every page of app. 
// It's purpose is to reduce redundand code.

if( ! isset($_SESSION)) {
    session_start(); 
}

$add = 'http://localhost/space-r/';
?>

<div id="pagetop">
  <div id="logo">
    <img class="logo-img"
	 src="<?php echo $add;?>SpaceR_logo.png"
	 alt="Space-R: Twoje miejsce w Przestrzeni">
  </div>
  <div id="menubar">
    <div id="menubar_left">
	<a class="baritem" href="<?php echo $add;?>home/home.php">Główna</a>
	<a class="baritem" href="<?php echo $add;?>blog/list.php">Blogi</a>
	<a class="baritem" href="<?php echo $add;?>gallery.php">Galeria</a>
	<a class="baritem" href="<?php echo $add;?>calendar/page.php">Kalendarz</a>
    </div>
    <div id="menubar_right">
	    <?php 
	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	    echo //"<div class='baritem'>Jesteś zalogowany</div>"
		"<a class='baritem' href='".$add."user/account.php'>Konto</a>"
		. "<a class='baritem' href='".$add."user/logout.php'>Wyloguj</a>";
	} else {
	    echo "<a class='baritem' href='".$add."user/login.php'>Logowanie</a>"
		. "<a class='baritem' href='".$add."user/signin.php'>Rejestracja</a>";
	}
	?>
    </div>
  </div>
</div>