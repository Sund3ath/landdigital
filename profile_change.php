<?php 
//include('database.php');
include('php_code.php');
 
$update = true;
$record = mysqli_query($db, "SELECT * FROM Benutzer WHERE idBenutzer LIKE '" . $_SESSION['user_id'] . "'");
    
$n = mysqli_fetch_array($record);
$vorname = $n['vnameBenutzer'];
$nachname = $n['nameBenutzer'];
$adresse = $n['Adresse'];
$eMail = $n['emailBenutzer'];

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
        
    
<?php $results = mysqli_query($db, "SELECT * FROM Benutzer WHERE idBenutzer LIKE '" . $_SESSION['user_id'] . "'"); ?>
        
    
<header>
		<a href="index.php"><img class="LogoLandDigital" src="Bilder\Logo.png"></a>	
		<a href="index.php"><input class="Button" type="button" name="index" ></a>
		<a href="profile_change.php"><input class="Button" type="button" name="profile" ></a>
        <a href="cart.php"><input class="Button" type="button" name="cart" ></a>
		<a href="logout.php"><input class="Button" type="button" name="logout" ></a>
</header>
    
    
   <!-- Begrüssung Personalisiert-->
		<div class="CartLogo">
            <h1 style="background: #4c85a8;">Benutzerprofil</h1>
            <h2 style="background: #8dbad6;">Willkommen <?php echo $vorname; ?>!</h2>
		</div>
    
    
<!-- Tabelle: Abfrage der Benutzerdaten-->    
<table>
	<thead>
		<tr>
			<th>Vorname</th>
			<th>Nachname</th>
            <th>Adresse</th>
            <th>E-Mail</th>
		</tr>
	</thead>
	<?php while ($row = mysqli_fetch_array($results)) { ?>
    	<tr>
			<td><?php echo $row['vnameBenutzer']; ?></td>
			<td><?php echo $row['nameBenutzer']; ?></td>
            <td><?php echo $row['Adresse']; ?></td>
            <td><?php echo $row['emailBenutzer']; ?></td>
		</tr>
	<?php } ?>
</table><br>



<!-- Bearbeitungsformular für das Benutzer Profil -->
    
    <form  action="update_benutzer.php" method="post">
         <div class="CartLogo">
            <h3 >Profil von <?php echo $vorname; ?> bearbeiten:</h3>
		</div>
          <div class="input-group">
			<label>Vorname</label>
			<input class="input-group" type="text" name="vorname" value="<?php echo $vorname; ?>">
		  </div>
          <div class="input-group">
			<label>Nachname</label>
			<input type="text" name="nachname" value="<?php echo $nachname; ?>">
		  </div>
          <div class="input-group">
			<label>Adresse</label>
			<input type="text" name="adresseBenutzer" value="<?php echo $adresse; ?>">
		  </div>

         <div class="submit-container">
         <input class="submit-button" type="submit" value="absenden" />
        </div>
    </form>
    
    <div class="CartLogo">
    <h2 style="background: #8dbad6;"><a href="profile.php">Fahrten Bestätigen</a></h2>
    </div>
    
    
    </body>  
</html>