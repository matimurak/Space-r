<?php

// the "exit_action()" parameters:
$DEBUGGING_MODE = false; // Swich on the to see echo error messages
$NOEXIT_MODE = false; // Runs despites warnings (possible memory leak!!)

require_once "../genpur/config.php";
require_once "../genpur/validation.php";
include "../genpur/get_userdata.php";
include "../genpur/input.php";

echo "-DB connection data: <br>"; print_r($conn); echo "<br><br>";

if (!isset($_SESSION)) {
    session_start();
}

$errormsg = "";	    // used to pass feedback to user (see: "exit_action()")

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "# Request method error.";
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    exit_action();
}
echo "-Received POST data: <br>"; print_r($_POST); echo "<br><br>";

// Current data will be used to replace empty input variables in sql query
$currdata = get_userdata();
if ( ! empty($udata['errormsg']) ) {
    echo "#Failed to get current data from db. <br>";
    $errormsg = $udata['errormsg'];
    exit_action();
} 

$username = sanitize_string($_POST["username"]);
$password = sanitize_string($_POST["password"]);
$conf_password = sanitize_string($_POST["conf_password"]);
$fname = sanitize_string($_POST["fname"]);
$lname = sanitize_string($_POST["lname"]);

// Validation functions return empty string when passed
if ( !empty(username_validate($username))
	|| !empty(username_isUnique($username))
	|| !empty(password_validate($password))
	|| !empty(password_confirm($password, $conf_password))
	|| !empty(name_validate($fname))
	|| !empty(name_validate($lname))
	) {
    echo "# Form data invalid. Errormsg: " . $GLOBALS['errormsg'] . "<br>"; //leave as is
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    exit_action();
}

echo "-Form data is valid. Preparing sql var and stmt... <br>";

$sql = "UPDATE users SET username=?, hashed_password=?, fname=?, lname=? WHERE id=?";
$stmt = mysqli_stmt_init($conn);
echo "-stmt: "; print_r($stmt); echo "<br>";

if ( ! mysqli_stmt_prepare($stmt, $sql)) {
    echo "# Failed to prepare mysqli statement. <br>";
    $errormsg = "Ups! Wystąpił błąd. Spróbuj ponownie później.";
    exit_action();
}

//$param_username = $param_hashedPassword = $param_fname = $param_lname = ""; $param_id;
echo "-MySQLi stmt prepared. Binding parameters... <br>";
mysqli_stmt_bind_param($stmt, "ssssi",
	$param_username,
	$param_hashedPassword,
	$param_fname,
	$param_lname,
	$param_id);

// Set bound parameters depending
if(!empty($username)) $param_username = $username; 
    else $param_username = $currdata['username'];
if(!empty($password)) $param_hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    else $param_hashedPassword = $currdata['hashed_password'];
if(!empty($fname)) $param_fname = $fname;
    else $param_fname = $currdata['fname'];
if(!empty($lname)) $param_lname = $lname;
    else $param_lname = $currdata['lname'];

$param_id = $_SESSION['id'];

echo "- Data from db: <br>"
	. "|_uname: " . $currdata['username'] . "<br>"
        . "|_hashed_password: " . $currdata['hashed_password'] . "<br>"
	. "|_lname: " . $currdata['fname'] . "<br>"
        . "|_fname: " . $currdata['lname'] . "<br>" 
	. "<br>";

echo "- Variables bound. MySQLi stmt execution... <br>";

if (mysqli_stmt_execute($stmt)) {
    echo "- Data update successful.";
    header("location: account.php");
} else {
    echo "# Error during MySQLi stmt execution.";
    $errormsg = "Ups! Coś poszło nie tak. Spróbuj ponownie później.";
    exit_action();
}


mysqli_stmt_close($stmt);

mysqli_close($conn);


//--- functions --------------------------------------------------------------//


function exit_action() {
    
    if (!$GLOBALS['DEBUGGING_MODE']) {
	header("location: account.php?errormsg=" . $GLOBALS['errormsg']); }
    if (!$GLOBALS['NOEXIT_MODE']) {
	if (isset( $GLOBALS['stmt'] )) {
	    mysqli_stmt_close( $GLOBALS['stmt'] ); 
	}
	if (isset( $GLOBALS['conn'] )) 
	    mysqli_close( $GLOBALS['conn'] ); 
	exit();
    }   
}
