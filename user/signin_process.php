<?php

// the "exit_action()" parameters:
$DEBUGGING_MODE = false; // Swich on the to see echo error messages
$NOEXIT_MODE = false; // Runs despites warnings (possible memory leak!!)

require_once "../genpur/config.php";
require_once "../genpur/validation.php";

echo "-DB connection data: "; print_r($conn); echo "<br><br>";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    echo "# Request method error. <br>";
    exit_action();
}
echo "-Received POST data: "; print_r($_POST); echo "<br><br>";

$username = sanitize_string($_POST["username"]);
$password = sanitize_string($_POST["password"]);
$conf_password = sanitize_string($_POST["conf_password"]);
$fname = sanitize_string($_POST["fname"]);
$lname = sanitize_string($_POST["lname"]);

//Validation func returns empty string when passed or error message when not.
if ( !empty(username_validate($username))
	|| !empty(username_isUnique($username))
	|| !empty(password_validate($password))
	|| !empty(password_confirm($password, $conf_password))
	|| !empty(name_validate($fname))
	|| !empty(name_validate($lname)) 
	) {
    echo "# Form data invalid.";
    exit_action();
}

echo "-Form data is valid. Preparing sql var and stmt... <br>";

$sql = "INSERT INTO users (username, hashed_password, fname, lname, createdon) "
	. "VALUES (?, ?, ?, ?, FROM_UNIXTIME(?))";
$stmt = mysqli_stmt_init($conn);

if ( !mysqli_stmt_prepare($stmt, $sql) ) {
    echo "# Error during mysqli stmt preparation. <br>".mysqli_error($conn);
    exit_action();
    //die(mysqli_error($conn));
} 

echo "-MySQLi stmt prepared. Bindinig... <br>";
mysqli_stmt_bind_param($stmt, "ssssi", 
	$param_username, 
	$param_hashedPassword,
	$param_fname,
	$param_lname,
	$param_createdon);

$param_username = $username;
$param_hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$param_fname = $fname;
$param_lname = $lname;
$param_createdon = time();

echo "-Variables bound. MySQLi stmt execution... <br>";

if (mysqli_stmt_execute($stmt)) {
    echo "- Signin successful.";
    header("location: login.php");
} else {
    echo "# Error during MySQLi stmt execution. <br>";
    $errormsg = "Ups! Coś poszło nie tak. Spróbuj ponownie później.";
    exit_action();
}


mysqli_stmt_close($stmt);

mysqli_close($conn);


//--- functions --------------------------------------------------------------//


function exit_action() {
    if (!$GLOBALS['DEBUGGING_MODE']) {
	header("location: signin.php?errormsg=" . $GLOBALS['errormsg']);
    } else {
	echo '<br>error message: ' . $GLOBALS['errormsg'];
    }
    if (!$GLOBALS['NOEXIT_MODE']) {
	if (isset( $GLOBALS['conn'] )) 
	    mysqli_close( $GLOBALS['conn'] ); 
	exit();
    }   
}
