<?php
session_start();

require 'database.php';
$str = $_GET['b'];
$strarray = explode("|", $str);                       //String wird in die benötigte Formatierung gebracht Produkt 1,2,3,...
$counter = count($strarray)-2;

for ($x = 0; $x <=$counter; $x++) {                   //Datenbanktabelle Bestellung wird aktualisiert mit der Adresse das Fahrers
  $fahrer = explode(":", $strarray[$x])[1];
  $verkaeufer = explode(":", $strarray[$x])[0];
  $strasse = explode(",", $verkaeufer)[0];
  $query = "SELECT Produkt1 FROM Bestellung WHERE adresseVerkaeufer LIKE '" . str_replace("ß","ss", $strasse). "%" . "'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $produktname = $stmt->fetch();
  //echo $produktname[0];
  $query= "UPDATE Bestellung SET adresseFahrer = '" . str_replace("ß","ss", $fahrer) . "' WHERE idBenutzer = '" . $_SESSION['user_id'] . "'" . " AND adresseVerkaeufer LIKE '" . str_replace("ß","ss", $strasse). "%" . "'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <script type="text/javascript">
    function openindex(){
      window.location.href="index.php";
    }
  </script>
  <body onload="openindex()">

  </body>
</html>
