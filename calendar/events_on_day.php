<?php

if (!isset($_SESSION)) 
    session_start();

require_once '../genpur/config.php';
require_once '../genpur/validation.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}

$day = to2digit(sanitize_string($_POST['chosenDay']));
$month = to2digit(sanitize_string($_POST['chosenMonth']));
$year = to2digit(sanitize_string($_POST['chosenYear']));

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
$events_assoc_arr = array();
$i = 0;
while($row = mysqli_fetch_array($result)) {
    $events_assoc_arr[$i] = $row;
    $i++;
}

mysqli_stmt_close($stmt);

$j = 0;
while($j < $i) {
    $events_assoc_arr[$j]['event_type'] = getEventType($events_assoc_arr[$j]['event_type_id']);
    $j++;
}


echo eventdetails_widget($events_assoc_arr, $i);



//--- functions --------------------------------------------------------------//

function getEventType($id) {
    $sql = 'SELECT type FROM event_types WHERE id = '.$id;
    $result = mysqli_query($GLOBALS['conn'], $sql);
    $output = mysqli_fetch_row($result)[0];

    return $output;
}

function to2digit($x) {
    if($x<10)
	$x = '0'.$x;
    return $x;
}

function eventdetails_widget($evarr, $evnum) {
    $output = '';
    $output .= '<div id="evdetails">';
    
    if($evnum == 0) {
	$output .= '<div class="evdetails_tile">'
		. '<div class="evemptymsg">'
		. 'Nie znaleziono wydarzeń wybranego dnia.</div></div>';
    } else {

	for($i=0; $i<$evnum; $i++) {
	    $output .= '
	    <div class="evdetails_tile">
	      <div class="evtitle">
		<div class="evnametype">
		  <div class="evname">'.$evarr[$i]["name"].'</div>
		  <div class="evtype">'.$evarr[$i]["event_type"].'</div>
		</div>
		<div class="evdatetime">
		  <div class="evdate">'.$evarr[$i]["date"].'</div>
		  <div class="evtime">'.$evarr[$i]["time"].'</div>
		</div>
	      </div>
	      <div class="evdesc">'.$evarr[$i]["description"].'</div>';
		  if(isset($_SESSION["admin"]) && $_SESSION["admin"]) {
		      $output .= '
	      <div class="ev_deletebtn" 
	      onclick="event_delete('.$evarr[$i]["id"].', \''.$evarr[$i]["name"].'\')">
	      Usuń</div>';
		  }
		  $output .= ' 
	    </div>';
	}
    }
    $output .= '</div>';
    return $output;
}