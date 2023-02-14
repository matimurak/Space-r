<?php
echo '<script>';
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo 'let loggedin = true;';
} else {
    echo 'let loggedin = false;';
}
if(isset($_SESSION['moderator']) && $_SESSION['moderator'] == true) {
    echo 'let moderator = true;';
} else {
    echo 'let moderator = false;';
}
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    echo 'let admin = true;';
} else {
    echo 'let admin = false;';
}
echo '</script>';