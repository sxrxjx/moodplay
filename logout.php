<?php

require_once 'init.php';

unset($_SESSION['email']);

unset($_SESSION['rol']);

if(isset($_COOKIE['session_activa'])){
    setcookie('session_activa', '', time() - 3600, '/');
}

session_destroy();

header("Location: login.php");

?>