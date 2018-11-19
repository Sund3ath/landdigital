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
<html><head>
	<title>Land.Digital Warenkorb</title>
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
</head>
<body>
	<?php if(isset($_SESSION['user_id'])): ?> 

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
		
		<div class="CartElements">
		<?php foreach( $result as $row ): ?>
		<?php $ergebnis  = $row["Produkt1"]; ?>
		<?php echo $ergebnis." - " ; ?>
		<?php endforeach; ?>
		</div>
		<!-- Nicht angemeldete Nutzer werden zum login weitergeleitet -->
		<!--<?php else: ?>-->
		<!--<?php header("Location: /dataland/login.php"); ?> -->
		<!--<?php endif; ?> -->
		
		<div class="OrderButton">
		<form action='cart.php' method='POST'>
		<input type="submit" name="BestellungAufgeben" value=" "> 
		</form>
		</div>
</body>
</html>
	 

