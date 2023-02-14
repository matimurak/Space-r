<?php

// the "exit_action()" parameters:
$DEBUGGING_MODE = false; // Swich on the to see echo error messages
$NOEXIT_MODE = false; // Runs despites warnings (possible memory leak!!)

require_once '../genpur/config.php';
require_once '../genpur/validation.php';

echo '- newevent_create.php';

echo '- DB connection data: '; print_r($conn); echo '<br><br>';
echo '- Received POST data: '; var_dump($_POST); echo '<br><br>';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errormsg = 'Ups! Wystąpił błąd. Spróbuj ponownie później.';
    echo '# Request method error. <br>';
    exit_action();
}

$date = sanitize_string($_POST['date']);
$name = sanitize_string($_POST['name']);
if(isset($_POST['type']))
    $type = sanitize_string($_POST['type']);
else
    $type = 'inne';
$desc = sanitize_string($_POST['desc']);
$dt_assoc = form_dateToAssoc($date);

if ( !empty(datetime_validate($dt_assoc))
	|| !empty(evname_validate($name))
	|| !empty(evtype_validate($type))
	|| !empty(evdesc_validate($desc))
	) {
    $errormsg = 'Błąd danych formularza. Sprawdź wprowadzone dane.';
    echo "# Form data invalid. Errormsg: " . $errormsg . "<br>";
    exit_action();
}
$type_id = evtype_findEventTypeId($type);

$sql = 'INSERT INTO events (name, event_type_id, date, time, description) '
	. 'VALUES (?, ?, ?, ?, ?)';
$stmt = mysqli_stmt_init($conn);

if ( !mysqli_stmt_prepare($stmt, $sql) ) {
    echo '# Cannot prepare MySQLi stmt. '; print_r($stmt);
    $errormsg = 'Ups! Wystąpił błąd. Spróbuj ponownie później.';
    exit_action();
}

mysqli_stmt_bind_param($stmt, 'sisss',
	$param_name,
	$param_type_id,
	$param_date,
	$param_time,
	$param_description);

$param_name = $name;
$param_type_id = $type_id;
$param_date = $dt_assoc['y'].'-'.$dt_assoc['mon'].'-'.$dt_assoc['d'];
$param_time = $dt_assoc['h'].':'.$dt_assoc['min'].':00';
$param_description = $desc;

if(mysqli_stmt_execute($stmt)) {
    echo '- Creating event successfull.';
    header('location: page.php');
} else {
    echo '# Error during MySQLi stmt execution.';
    $errormsg = 'Ups! Coś poszło nie tak. Spróbuj ponownie później.';
    exit_action();
}

var_dump($param_name);
var_dump($param_type_id);
var_dump($param_date);
var_dump($param_time);
var_dump($param_description);

mysqli_close($conn);
	

//--- functions --------------------------------------------------------------//


// Input format is form input type of local-datetime.
// example "2023-08-12T09:43"
function form_dateToAssoc($datetime_string) {
    $datetime_arr = explode('T',$datetime_string);
    $date_arr = explode('-', $datetime_arr[0]);
    $time_arr = explode(':', $datetime_arr[1]);
    $datetime_assoc = array(
	'y'=>$date_arr[0], 
	'mon'=>$date_arr[1], 
	'd'=>$date_arr[2], 
	'h'=>$time_arr[0], 
	'min'=>$time_arr[1] 
	);
    return $datetime_assoc;
}

function evname_validate($input) {
    $errormsg = '';
    if (!isset($input)) {
	$errormsg = 'Należy podać nazwę wydarzenia';
    } elseif (strlen($input)>255) {
	$errormsg = 'Nazwa może mieć maksymalnie 255 znaków';
    } /*elseif (! preg_match(regex)) {}*/
    $GLOBALS['errormsg'] = $errormsg;
    return $errormsg;
}

function evtype_validate($input) {
    $errormsg = '';
    if ( !($input === 'Wydarzenie społeczności'
	    || $input === 'Wydarzenie Słońca'
	    || $input === 'Wydarzenie Księżyca'
	    || $input === 'Zaćmienie'
	    || $input === 'Koniunkcja'
	    || $input === 'Kometa'
	    || $input === 'Inne') 
	    ) {
	$errormsg = 'Nieprawidłowy typ wydarzenia';
    }
    return $errormsg;
}
function evtype_findEventTypeId($eventType) {
    $errormsg = 'Ups! Wystąpił błąd. Spróbuj ponownie później.';
    $sql = 'SELECT id FROM event_types WHERE type = ?';
    $stmt = mysqli_stmt_init($GLOBALS['conn']);
    if(mysqli_stmt_prepare($stmt, $sql)) {
	mysqli_stmt_bind_param($stmt, 's', $param_eventType);
	$param_eventType = $eventType;
	if(mysqli_stmt_execute($stmt)) {
	    mysqli_stmt_bind_result($stmt, $eventType_id);
	    mysqli_stmt_fetch($stmt);
	} else {
	    $GLOBALS['errormsg'] = $errormsg;
	}
    } else {
	$GLOBALS['errormsg'] = $errormsg;
    }
    mysqli_stmt_close($stmt);
    return $eventType_id;
}

function evdesc_validate($input) {
    $errormsg = '';

    return $errormsg;
}

function exit_action() {
    
    if (!$GLOBALS['DEBUGGING_MODE']) {
	header("location: page.php?errormsg=" . $GLOBALS['errormsg']);
    }
    if (!$GLOBALS['NOEXIT_MODE']) { 
	if (isset( $GLOBALS['conn'] )) 
	    mysqli_close( $GLOBALS['conn'] ); 
	exit();
    }   
}