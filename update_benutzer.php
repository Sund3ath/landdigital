<?php

session_start();

$servername = "localhost";
$username = 'ich';
$password = 'mikorch3';
$dbname = "dataland";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


//$vorname_ist = &row['vnameBenutzer'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$vorname = $_POST['vorname'];
//$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];   
$adresseBenutzer = $_POST['adresseBenutzer']; 


$sql = "UPDATE Benutzer SET
    vnameBenutzer='$vorname', 
    nameBenutzer='$nachname',
    Adresse='$adresseBenutzer'
    WHERE idBenutzer LIKE '" . $_SESSION['user_id'] . "'";



if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();

header("Location: profile_change.php");
?>

