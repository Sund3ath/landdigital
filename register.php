
<?php

if(isset($_SESSION['user_id'])){	//Falls User bereits eingeloogt, soll er nicht mehr in der Lage sein die Register-Seite zu besuchen. Er wird an die Hauptseite weitergeleitet
	header("Location: /dataland/index.php");
}

require 'database.php';

$message ='';

if(!empty($_POST['emailBenutzer']) && !empty($_POST['passwort'])): //Prüfen ob Eingabefeld für Email und Passwort nicht leer
	
	//Neuen Nutzer in DB anlegen 
	$sql = "INSERT INTO Benutzer (emailBenutzer, vnameBenutzer, nameBenutzer, passwort, Strasse, Hausnummer, PLZ, Ort) VALUES (:emailBenutzer, :vnameBenutzer, :nameBenutzer, :passwort, :Strasse, :Hausnummer, :PLZ, :Ort)"; // Zeile 8 =Query  //Code muss an jede Datenband angepasst werden  ":"steht für column
	$stmt =  $conn->prepare($sql);  
	
	$stmt->bindParam(':emailBenutzer', $_POST['emailBenutzer']);
	$stmt->bindParam(':vnameBenutzer', $_POST['vnameBenutzer']);
	$stmt->bindParam(':nameBenutzer', $_POST['nameBenutzer']);
	$stmt->bindParam(':Strasse', $_POST['Strasse']);
	$stmt->bindParam(':Hausnummer', $_POST['Hausnummer']);
	$stmt->bindParam(':PLZ', $_POST['PLZ']);
	$stmt->bindParam(':Ort', $_POST['Ort']);
	//$password = password_hash($_POST['passwort'], PASSWORD_BCRYPT);  //password_hash-Funktion => Passwort wird verschlüsselt in DB gespeichert
	$stmt->bindParam(':passwort',$_POST['passwort']);						 //password_hash-Funktion => Passwort wird verschlüsselt in DB gespeichert
	
	
		//Bestätigung falls User erfolgreich angelegt wurde
	if ($stmt->execute() ):
		$message = 'Registrierung war erfolgreich';  //Sicherung des Strings in Varibale $Message, jedoch keine Ausgabe, Ausgabe in Zeile 41
	else:
		$message = 'Es gab ein Problem bei der Registrierung';
	endif;
	
endif;

?>


<!DOCTYPE html>
<html>
<head>
	<title>Land.Digital Register</title>
	<link rel="stylesheet" type="text/css" href="Design.css">
	
</head>
<body>
		
		<div class="logo" align="right">
			<a href="index.php"><img class="logo" src="Bilder\Logo.png"></a><!--Durch Klicken auf den Text, wird man zur Startseite weitergeleitet-->
		</div>
		 
		<div class="content" >
			
			
			<div><img class="benutzerimg" src="Bilder\Benutzer.png"></div> <br>
			<!--<h1>Registrieren</h1>-->
		
				
					<!-- Ausgabe der (Fehler)-Nachricht auf dem Bildschrim -->
				<?php if(!empty($message)): ?>
					<p><?= $message ?></p>  
				<?php endif; ?> 
		
		
			<form action="register.php" method="POST"> <!--action="register.php" bedeutet: Post to register.php -->
			<div class="teil1">
			<input class="input" type="text" placeholder="Vorname" name="vnameBenutzer">
			<input class="input" type="text" placeholder="Nachname" name="nameBenutzer">
			<input class="input" type="text" placeholder="Email" name="emailBenutzer">  	<!-- Boxen für Email und Passwort-Eingabe-->
			<input class="input" type="password" placeholder="Passwort" name="passwort">
			<!--<input class="input" type="password" placeholder="Passwort wiederholen" name="confirm_passwort"> -->
			</div>
			<div class="teil2">
			<input class="input" type="text" placeholder="Strasse" name="Strasse">  
			<input class="input" type="text" placeholder="Hausnummer" name="Hausnummer">  
			<input class="input" type="text" placeholder="PLZ" name="PLZ"> 
			<input class="input" type="text" placeholder="Ort" name="Ort">	
			</div>
			<br>
			<input class="submitButton" type="submit" value="Registrieren">	<br><br><br>	<!-- Absende/ Bestätigungs Button, Value gibt die Beschriftung des Buttons an -->
			<span> <img class="pfeilimg" src="Bilder\PfeilRechts.png"><a href="login.php">oder hier einloggen</a></span>  <!-- <span> verwenden um dieses Element besser über CSS anzusprechen-->
			</form>
		</div>
		

</body>
</html>