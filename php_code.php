<?php 

session_start();

 $servername = "inf-education-35.umwelt-campus.de";
 $username = 'ko_landdigital';
 $password = 'BPL9qJyjfqMZHCAt';
$dbname = "LandDigital";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

?>