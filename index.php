<?php
session_start();

require 'database.php';

if(!empty($_POST['searchBar'])){
$var1 = "";
$varzahl = 0;
$var1 = $_POST['searchBar'];


$query = "SELECT * FROM Produkt WHERE nameProdukt = '".$_POST['searchBar']."'";
$stmt = $conn->prepare($query);
$stmt->execute();


//$pName = "";
//$pPreis = "";
//$Verkaeufer = "";

if ($stmt->rowCount() > 0) {
$result = $stmt->fetchAll();

foreach( $result as $row ) {
$pName  = $row["nameProdukt"];
$pPreis = $row["Preis"];
$pVerkaeufer = $row["verkaeuferProdukt"];
}

} else
{
$noResults = 'Keine Treffer';
}



}
?>





<!DOCTYPE html>
<html><head>
	<title>Land.Digital Index</title>
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
	<link rel="shortcut icon" href="Bilder/Einkaufswagen.ico">


	</div>
</head>
<body>
		<?php if(isset($_SESSION['user_id'])): ?>		 <!-- nur eingeloggte User können auf Website zugreifen -->

	<header>
		<a href="index.php"><img class="LogoLandDigital" src="Bilder\Logo.png"></a>
		<a href="cart.php"><input class="Button" type="button" name="cart" ></a>
		<a href="profile.php"><input class="Button" type="button" name="profile" ></a>
		<a href="index.php"><input class="Button" type="button" name="menu" ></a>
		<a href="logout.php"><input class="Button" type="button" name="logout" ></a>
	</header>

	<div class="SearchLogo">
		<img class="SearchLogoImg" src="Bilder\Lupe.png">
	</div>

	<div class="content" >
		<div class="SearchFunction">
			<form action="index.php" method="POST">
				<input id="searchBar" type="text" name="searchBar" placeholder="                  Was darf´s sein?">
				<input id="submit" class="search" type="submit" name="search" value=" ">
			</form>
		</div>
	</div>

	<div class="SearchResult">
		<?php if(!empty($_POST['searchBar'])): ?>
		<?php if($stmt->rowCount() > 0): ?>
				<p><br><?= $pName ?><br><br>Preis: 0.<?= $pPreis ?>€ <br> von: <?= $pVerkaeufer ?> </p>

				<form action='index.php' method='POST'>
					<input type="submit" name="ja" value=" ">
				</form>
				<?php 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "INSERT INTO Bestellung (Produkt1, idBenutzer)
						VALUES (('" .$pName. "'),('" .$_SESSION['user_id']."'))";
					$conn->exec($sql); ?>
		<?php else: ?>
			<p><?= $noResults ?> </p>

		<?php endif; ?>
		<?php endif; ?>
	</div>

	<!-- Nicht angemeldete Nutzer werden zum login weitergeleitet -->
	<?php else: ?>
	<?php
		session_start();
		header("Location: /dataland/login.php"); ?>
	<?php endif; ?>

</body>
</html>
