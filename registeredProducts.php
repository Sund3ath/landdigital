<?php
session_start();

require 'database.php';

error_reporting(0);

$query="SELECT * FROM Produkt WHERE idVerkaeufer = '" . $_SESSION['user_id'] . "'";
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
		<h3 align="center">Registrierte Produkte</h3>
		<br>
		<div  class="table-responsive p-4">
			<table class="table table-striped table-bordered table-hover">
				<tr>
						<th width=30% style="text-align: center; vertical-align: middle";>Artikel</th>
						<th width=10% style="text-align: center; vertical-align: middle";>Preis</th>
						<th width=10% style="text-align: center; vertical-align: middle";>Verfügbarkeit</th>
						<th width=30% style="text-align: center; vertical-align: middle";>Vorschau</th>
						<th width=20% style="text-align: center; vertical-align: middle";>Aktion</th>
				</tr>
				
			<?php

			foreach( $result as $row ): 
			$name  = $row["nameProdukt"];
			$preis = $row["Preis"];
			$verf = $row["anzahlVerfuegbar"];
			$pic = $row["Vorschau"];
			$id = $row["idProdukt"]?>
			<tr>
				<td style="text-align: center; vertical-align: middle";><?php echo $name." " ;?></td>
				<td style="text-align: center; vertical-align: middle";><?php echo $preis." " ;?></td>
				<td style="text-align: center; vertical-align: middle";><?php echo $verf." " ;?></td>
				<td style="text-align: center; vertical-align: middle";><img src = "<?php echo $pic ?>" width="100" height="100">
				<td style="text-align: center; vertical-align: middle";><a href="editproduct.php?product=<?php echo $id ?>">bearbeiten</a></td>
			</tr>
			<?php endforeach;?>
			</table>
		</div>
</body>
</html>

			