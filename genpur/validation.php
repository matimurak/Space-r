<?php

$GLOBALS['errormsg'] = ''; // used to pass feedback to user (see: "exit_action()")

//---sanitize functions---//
function sanitize_string($input) {
    return trim(htmlspecialchars($input));
}

//---validation functions---//
// Validation functions return empty string when passed or error when not.
// They also set global var $errormsg.

// Validating username (empty, regex, max length)
function username_validate($username) {
    $errormsg = "";
    if (empty($username)) {
	$errormsg = "Należy wprowadzić nazwę użytkownika.";
    } 
    elseif ( ! preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
	$errormsg = "Nazwa użytkownika może składać się tylko z liter, "
		. "liczb i podkreślników.";
    } 
    elseif (strlen(trim($_POST["username"])) > 40) {
	$errormsg = "Maksymalna długość nazwy użytkownika to 40 znaków";
    }
    else {
	$errormsg = username_isUnique($username);
    }
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

// Searching for username duplicates in users database 
// Used in username_validate()
function username_isUnique($username) {
    $errormsg = "";
    $param_username = "";
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_stmt_init($GLOBALS["conn"]);

    if ( ! mysqli_stmt_prepare($stmt, $sql)) {
	$errormsg = "Ups! Coś poszło nie tak. (Error while preparing SQL statement.)";
    } else {
	mysqli_stmt_bind_param($stmt, "s", $param_username); 
	$param_username = $username;

	if( ! mysqli_stmt_execute($stmt)) {
	    $errormsg = "Ups! Coś poszło nie tak. (Error while executing SQL statement.)";
	} else {
	    mysqli_stmt_store_result($stmt);

	    //Is username unique?
	    if(mysqli_stmt_num_rows($stmt) != 0) {
		$errormsg = "Ta nazwa jest już zajęta.";
	    }
	}
	
	mysqli_stmt_close($stmt);
    } 
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

// Password validation (empty or too short)
function password_validate($password) {
    $errormsg = "";
    if (empty($password)) {
	$errormsg = "Wprowadź hasło.";     
    } elseif (strlen(trim($_POST["password"])) < 8) {
	$errormsg = "Stwórz silne hasło z conajmniej 8 znaków.";
    }
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

// Matching passwords
function password_confirm($password, $conf_password) {
    $errormsg = "";
    if ($password != $conf_password) {
	$errormsg = "Hasła muszą być identyczne.";
    }
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

function name_validate($name) {
    $errormsg = "";
    if ( ! preg_match('/^[a-zA-ZąęćśźżłóńĄĘĆŚŹŻŁÓŃ]+$/', $name)) {
	$errormsg = "Imię i nazwisko może składać się tylko z liter.";
    } 
    elseif (strlen($name) > 40) {
	$errormsg = "Maksymalna długość imienia i nazwiska to 40 znaków";
    }
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

function datetime_validate($da) {
    $errormsg = '';
    if($da['y'] === null
	    || $da['mon'] === null
	    || $da['d'] === null
	    || $da['h'] === null
	    || $da['min'] === null
	    ) {
	$errormsg = 'Błąd daty.';
    } elseif ($da['y']<1000 || $da['y']>9999
	    || $da['mon']<1 || $da['mon']>12
	    || $da['d']<1 || $da['d']>31
	    || $da['h']<0 || $da['h']>23
	    || $da['min']<0 || $da['min']>59
	    ) {
	$errormsg = 'Błąd daty.';
    }
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

function day_validate($input) {
    $errormsg = '';
    if($input<1 || $input>31 || strlen($input)!=2) {
	$errormsg = 'Błąd daty: dzień.';
    }
    return $errormsg;
}
function month_validate($input) {
    $errormsg = '';
    if($input<1 || $input>12 || strlen($input)!=2) {
	$errormsg = 'Błąd daty: miesiąc.';
    }
    return $errormsg;
}
function year_validate($input) {
    $errormsg = '';
    if($input<1 || $input>4000 || strlen($input)!=4) {
	$errormsg = 'Błąd daty: rok.';
    }
    return $errormsg;
}

