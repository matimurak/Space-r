<?php 
// This php file contains inset variation of "topbar.php".
// It is meant to be included into every page that exists inside a folder.
// It's purpose is to fix links.

if( ! isset($_SESSION)) {
    session_start(); 
}
?>

<div id="pagetop">
  <div id="logo">
    <img class="logo-img"
	 src="../SpaceR_logo.png"
	 alt="Space-R: Twoje miejsce w Przestrzeni">
  </div>
  <div id="menubar">
    <div id="menubar_left">
	<a class="baritem" href="http://localhost/Inzynierka/inz1/home.php">Główna</a>
	<a class="baritem" href="../blog/blogs.php">Blogi</a>
	<a class="baritem" href="../gallery.php">Galeria</a>
	<a class="baritem" href="../calendar/page.php">Kalendarz</a>
	<a class="baritem" href="../index_1.php">index_1</a>
    </div>
    <div id="menubar_right">
	<?php 
	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	    echo //"<div class='baritem'>Jesteś zalogowany</div>"
		"<a class='baritem' href='../user/account.php'>Konto</a>"
		. "<a class='baritem' href='../user/logout.php'>Wyloguj</a>";
	} else {
	    echo "<a class='baritem' href='../user/login.php'>Logowanie</a>"
		. "<a class='baritem' href='../user/signin.php'>Rejestracja</a>";
	}
	?>
    </div>
  </div>
</div>