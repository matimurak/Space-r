<?php

require_once "../genpur/config.php";

if (!isset($_SESSION)) {
    session_start();
}

function get_userdata() {
    $udata['errormsg'] = "";
    
    $sql = "SELECT username, hashed_password, admin, moderator, fname, lname "
	    . "FROM users WHERE id=?";
    $stmt = mysqli_stmt_init($GLOBALS['conn']);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
	echo  "# Error while preparing SQL statement.";
	$udata['errormsg'] = "Ups! Coś poszło nie tak.";
    } else {
	mysqli_stmt_bind_param($stmt, "i", $param_id); 
	$param_id = $_SESSION['id'];

	if (!mysqli_stmt_execute($stmt)) {
	    echo "# Error while executing SQL statement.";
	    $udata['errormsg'] = "Ups! Coś poszło nie tak.";
	} else {
	    mysqli_stmt_bind_result($stmt, 
		    $udata['username'],
		    $udata['hashed_password'],
		    $udata['admin'],
		    $udata['moderator'],
		    $udata['fname'],
		    $udata['lname']
		    );
	    mysqli_stmt_fetch($stmt);
	}
	
    }
    
    mysqli_stmt_close($stmt);
    return $udata;
}