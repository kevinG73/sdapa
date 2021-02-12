<?php
session_start();
$_SESSION['connecte'] = "";

if (session_destroy()) {
    header("Location: login.php");
}
?>