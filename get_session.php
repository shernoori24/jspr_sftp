<?php
require_once 'session_init.php';
echo 'Session ID : ' . session_id() . '<br>';
echo $_SESSION['test'] ?? 'Session non initialisée.';
