<?php

session_start();

$servername = "inf-education-35.umwelt-campus.de";
$username = 'ko_landdigital';
$password = 'BPL9qJyjfqMZHCAt';
$dbname = "LandDigital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);




// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$name = $_POST['name'];
$preis = $_POST['preis'];   
$verfuegbar = $_POST['verfuegbar']; 
$id = $_GET['product'];


$sql = "UPDATE Produkt SET
    nameProdukt='$name', 
    Preis='$preis',
    anzahlVerfuegbar='$verfuegbar'
    WHERE idProdukt = '$id'";



if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
header("Location: editproduct.php?product=$id");
?>