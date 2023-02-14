<?php

if (!isset($_SESSION)) 
    session_start();

require_once '../genpur/config.php';
require_once '../genpur/validation.php';

if (!isset($_SESSION['moderator']) || !$_SESSION['moderator']) {
    die();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}

$id = sanitize_string($_POST['id']);

if( !empty(id_validate($id)) ) {
    die();
}

$sql = 'DELETE FROM events WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $param_id);
$param_id = $id;

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);


function id_validate($id) {
    $errormsg = '';
    if($id <= 0) {
	$errormsg = 'Błąd id wydarzenia.';
    }
    return $errormsg;
}