<?php
session_start();

require 'database.php';

error_reporting(0);

$query="SELECT Produkt1 FROM Bestellung WHERE idBenutzer LIKE '" . $_SESSION['user_id'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();


if ($stmt->rowCount() > 0) {
$result = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Land.Digital Warenkorb</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
</head>
<body>


	<header>
		<a href="index.php"><img class="LogoLandDigital" src="Bilder\Logo.png"></a>
		<a href="index.php"><input class="Button" type="button" name="index" ></a>
		<a href="profile.php"><input class="Button" type="button" name="profile" ></a>
		<a href="index.php"><input class="Button" type="button" name="menu" ></a>
		<a href="logout.php"><input class="Button" type="button" name="logout" ></a>
	</header>

		<div class="CartLogo">
			<img class="CartLogoImg" src="Bilder\Einkaufswagen.png">
		</div>
		<h3 align="center">Order Details</h3>
		<br>
		<div  class="table-responsive p-4">
			<table class="table table-striped table-bordered table-hover">
				<tr>
						<th width=40%>Artikel</th>
						<th width=20%>Preis</th>
						<th width=10%>Menge</th>
						<th width=30%>Aktion</th>
				</tr>


			<?php

			foreach( $result as $row ):
			 $ergebnis  = $row["Produkt1"];
			 $query= "SELECT idVerkaeufer FROM Produkt WHERE nameProdukt LIKE '" . $ergebnis . "'";
			 $stmt = $conn->prepare($query);
			 $stmt->execute();
			 $idSeller = $stmt->fetch();
			 $query= "UPDATE Bestellung SET idVerkaeufer = '". $idSeller[0] ."' WHERE idBenutzer = '" . $_SESSION['user_id'] . "'" . "AND Produkt1 = '" . $ergebnis . "'";
			 $stmt = $conn->prepare($query);
			 $stmt->execute();
			 $query= "SELECT Adresse FROM Verkaeufer WHERE idVerkaeufer LIKE '" . $idSeller[0] . "'";
			 $stmt = $conn->prepare($query);
			 $stmt->execute();
			 $adresseSeller = $stmt->fetch();
			 $query= "UPDATE Bestellung SET adresseVerkaeufer = '". $adresseSeller[0] ."' WHERE idBenutzer = '" . $_SESSION['user_id'] . "'" . "AND Produkt1 = '" . $ergebnis . "'";
			 $stmt = $conn->prepare($query);
			 $stmt->execute();?>
			 <tr>
			 	<td><?php echo $ergebnis." " ;?></td>
				<td><?php echo $ergebnis." " ;?></td>
				<td><?php echo $ergebnis." " ;?></td>
				<td><a href="cart.php?action=delete&id=<?php $query= "DELETE FROM Bestellung WHERE Product1 = '" . $ergebnis . "'";?>
				<?php$stmt = $conn->prepare($query);?>
				<?php$stmt->execute();?>"><span class="text-danger">Remove</span></a></td>
			 </tr>
			 <?php endforeach;?>
		</table>
		</div>
		<div class="OrderButton">
			<form action='confirm.php'>
				<input type="submit" name="BestellungAufgeben" value=" ">
			</form>
		</div>
</body>
</html>
