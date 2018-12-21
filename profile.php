<?php 
include('php_code.php');

 
$update = true;
$record = mysqli_query($db, "SELECT * FROM Lieferung");
$n = mysqli_fetch_array($record);

$idLieferung = $n['idLieferung'];
$name = $n['Fahrtstrecke'];
$points = $n['drivePoints'];


//Übergabe der Daten der ausgewählten Lieferung
if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM Lieferung WHERE idLieferung=$id");

		if (@count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
            $idLieferung = $n['idLieferung'];
			$name = $n['Fahrtstrecke'];
			$points = $n['drivePoints'];
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Land.Digital Benutzer</title>
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
    <link rel="stylesheet" type="text/css" href="tablestyle.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
              
    
<header>
		<a href="index.php"><img class="LogoLandDigital" src="Bilder\Logo.png"></a>	
		<a href="index.php"><input class="Button" type="button" name="index" ></a>
	    <a href="profile_change.php"><input class="Button" type="button" name="profile" ></a>
        <a href="cart.php"><input class="Button" type="button" name="cart" ></a>
		<a href="logout.php"><input class="Button" type="button" name="logout" ></a>
</header>
    
    
<!-- Auslesen der Benutzer Daten -->    
<?php $result = mysqli_query($db, "SELECT * FROM Benutzer WHERE idBenutzer LIKE '" . $_SESSION['user_id'] . "'"); 
    
    $n = mysqli_fetch_array($result);
    $vorname = $n['vnameBenutzer'];
    $b_route = $n['Route'];
    ?>

    
<!-- Verknüpfung der Fahrerstrecke mit den Lieferungen anhand Fahrt ID -->
<?php $results = mysqli_query($db, "SELECT * FROM Lieferung WHERE Fahrtstrecke = $b_route"); ?>

		<div class="CartLogo">
            <h1 style="background: #4c85a8;">Lieferungen von <?php echo $vorname; ?> </h1>
		</div>
    
    	<div class="CartLogo">
            <h2 style="background: #8dbad6;">Fahrten bestätigen</h2>
		</div>
    
 
<!-- Wiedergabe der Benutzerspezifischen Lieferungen anhand der angegebenen Fahrtroute -->
<table>
	<thead>
		<tr>
            <th>Liefernummer</th>
			<th>Fahrt</th>
            <th>DrivePoints</th>
            <th>Bestätigt</th>
			<th>Fahrt Bestätigen</th>
		</tr>
	</thead>
<?php while ($row = mysqli_fetch_array($results)) { ?>	
    	<tr>
            <td><?php echo $row['idLieferung']; ?></td>
			<td><?php echo $row['Fahrtstrecke']; ?></td>
			<td><?php echo $row['drivePoints']; ?></td>
            <td style="background: #b8dcf2;"><?php echo $row['zusage']; ?></td>
            <td>
                <div class="input-group"><a href="profile.php?edit=<?php echo $row['idLieferung']; ?>" class="submit-button" >Auswählen</a></div>
			</td>
		</tr>
	<?php } ?>
</table>
    

        
<!-- Ausgewählte Fahrt bestätigen -->
	<form method="post" action="confirm_drive.php" >
        <!-- Liefernummer wird übergeben -->
        <div class="CartLogo">
            <h3>Ausgewählte Lieferung bestätigen</h3>
		</div>
        <div class="input-group">
			<label class="del_btn">Liefernummer</label>
            <label class="msg"><?php echo $idLieferung; ?></label>
		</div>
        
        <!-- Fahrtstrecke wird übergeben -->
		<div class="input-group">
			<label class="del_btn">Fahrtstrecke</label>
            <label class="msg"><?php echo $name; ?></label>
		</div>
        
        <!-- Mögliche Punkte werden übergeben -->
		<div class="input-group">
			<label class="del_btn">Mögliche Drivepoints</label>
            <label class="msg"><?php echo $points; ?></label>
		</div>
        
        <!-- Übergabe der Liefernummer versteckt -->
        <input name='Liefernummer' type="hidden" value="<?php echo $idLieferung; ?>">
        
        <!-- Bestätigung der Lieferung  -->
		<div class="input-group">
			<button class="submit-button" type="submit" name="ja_confirm" style="background: #4c85a8;" >Bestätigen</button>
			<button class="submit-button" type="submit" name="nein_confirm" style="background: #4c85a8;" >Rücknahme</button>
		</div>
	</form>
    
    
        <div class="CartLogo">
            <h3><a href="profile_change.php">Noch keine Drive Points? Hier als Fahrer registrieren</a></h3>
		</div>
		

        <div class="CartLogo">
            <h2 style="background: #8dbad6;"><a href="profile_change.php">Benutzerprofil Bearbeiten</a></h2>
		</div>
		
</body>
</html>
	 

