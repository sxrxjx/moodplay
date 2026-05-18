<?php

if(isset($_COOKIE['session_activa'])){
    $sessionId = $_COOKIE['session_activa'];
    session_id($sessionId);
    
}

session_start();

?>