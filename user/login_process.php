<?php

// the "exit_action()" parameters:
$DEBUGGING_MODE = false; // Swich on the to see echo error messages
$NOEXIT_MODE = false; // Runs despites warnings (possible memory leak!!)

require_once "../genpur/config.php";
require_once "../genpur/validation.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

echo "<h1>Napotkano błąd :(</h1><br>"
    ."<h2><a href=\"login.php\">Powrót do strony logowania</a></h2><br><br>";

echo "- DB connection data: "; print_r($conn); echo "<br><br>";
echo "- Received POST data: "; print_r($_POST); echo "<br><br>";

// declarations
$errormsg = "";
$username = sanitize_string($_POST["username"]);
$password = sanitize_string($_POST["password"]);

if ( ! $_SERVER["REQUEST_METHOD"] === "POST") {
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    exit_action();
    //die("Request method error"); 
}

if (empty($username) || empty($password)) {
    echo"form data is invalid. <br>";
    $errormsg = "Uzupełnij pola.";
    exit_action();
    //die("Form data invalid.");
} 
echo "- Form data is valid. MySQLi stmt preparing...<br>";

$sql = "SELECT id, hashed_password, admin, moderator FROM users WHERE username=?";
$stmt = mysqli_stmt_init($conn);

if( ! mysqli_stmt_prepare($stmt, $sql)) {
    echo "# Error during mysqli stmt preparation. <br>";
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    exit_action();
} else {
    echo"- MySQLi stmt prepared. Binding parameters...<br>";
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username; 

    if( ! mysqli_stmt_execute($stmt) && empty($errormsg)) {
	echo "# Error during sql stmt execution.<br>";
	$errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
	exit_action();
    }
    mysqli_stmt_store_result($stmt);

    //Checking if user exists
    if(mysqli_stmt_num_rows($stmt) != 1 /*&& empty($errormsg)*/) {
	echo "# User not found. Mysqli_stmt_num_rows: " . mysqli_stmt_num_rows($stmt) . "<br>";
	$errormsg = "Użytkownik o tej nazwie nie istnieje.";
	exit_action();
    } else {
	
	// Binding MySQL result to php variables
	// The password received from database is hashed
	mysqli_stmt_bind_result($stmt, 
		$id, 
		$hashed_password, 
		$admin, 
		$moderator); 

	if( ! mysqli_stmt_fetch($stmt)) {
	    echo "# Error fetching server answer.<br>";
	    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
	    exit_action();
	    
	} elseif ( ! password_verify($password, $hashed_password)) {
	    echo "# Invalid password<br>";
	    $errormsg = "Nieprawidłowa nazwa użytkownika lub hasło.";
	    exit_action();
	} else {
	    session_start();
	    $_SESSION["loggedin"] = true;
	    $_SESSION["id"] = $id;
	    $_SESSION["username"] = $username;
	    $_SESSION["admin"] = $admin;
	    $_SESSION["moderator"] = $moderator;
	}
    }
    mysqli_stmt_close($stmt);
}
 
mysqli_close($conn);

if(empty($errormsg)) {
    $redirect_link = "../index.php";
} else {
    $redirect_link = "login.php?errormsg=" . $errormsg;
}
header("location: " . $redirect_link);


function exit_action() {
    
    if (!$GLOBALS['DEBUGGING_MODE']) {
	header("location: login.php?errormsg=" . $GLOBALS['errormsg']);
    }
    if (!$GLOBALS['NOEXIT_MODE']) {
	if (isset( $GLOBALS['conn'] )) 
	    mysqli_close( $GLOBALS['conn'] ); 
	if (isset( $GLOBALS['stmt'] )) 
	    mysqli_stmt_close( $GLOBALS['stmt'] ); 
	exit();
    }   
}

?>