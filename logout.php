<?php
session_start();

require 'database.php';

unset($_SESSION['user_id']); 
session_destroy();

header("Location: /dataland/login.php");

?>