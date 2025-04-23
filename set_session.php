<?php
require_once 'session_init.php';
$_SESSION['test'] = 'Session active';
echo 'Session initialisée.<br>';
echo 'Session ID : ' . session_id();
