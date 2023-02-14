<?php

require_once '../genpur/config.php';
require_once '../genpur/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}

$day = to2digit(sanitize_string($_POST['day']));
$month = to2digit(sanitize_string($_POST['month']));
$year = sanitize_string($_POST['year']);

if ( !empty(day_validate($day))
	|| !empty(month_validate($month))
	|| !empty(year_validate($year))
	) {
    die();
}

$sql = 'SELECT * FROM events WHERE date = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $date);
$date = $year.'-'.$month.'-'.$day;

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) == 0){
    echo 'false';
} else {
    echo 'true';
}

mysqli_stmt_close($stmt);


//--- functions --------------------------------------------------------------//

function to2digit($x) {
    if($x<10)
	$x = '0'.$x;
    return $x;
}