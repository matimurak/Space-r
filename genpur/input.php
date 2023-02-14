<?php

function sanitize($input) {
    echo "-sanitize():<br>";
    if(!empty($input)) {
	echo "--\$input = $input<br>";
	$input = trim($input);
	$input = strip_tags($input);
	$input = htmlspecialchars($input);
    } else echo "--\$input is empty<br>";
    return $input;
}