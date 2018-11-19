
<?php
session_start();		 				//notwendig falls man Sessions verwendet


if(isset($_SESSION['user_id'])){	//Falls User bereits eingeloogt, soll er nicht mehr in der Lage sein die Login-Seite zu besuchen. Er wird an die Hauptseite weitergeleitet
	header("Location: /dataland/index.php");
}


require 'database.php';

if(!empty($_POST['emailBenutzer']) && !empty($_POST['passwort'])):

	$records = $conn->prepare('SELECT idBenutzer, emailBenutzer, passwort FROM Benutzer WHERE emailBenutzer = :emailBenutzer'); //Zugriff auf Daten aus DB
	$records->bindParam(':emailBenutzer', $_POST['emailBenutzer']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	//if(count($results) > 0 && password_verify($_POST['passwort'], $results['passwort']) ){
	if(count($results) > 0 && $_POST['passwort'] ==$results['passwort'] ){//Falls eingegebene Email in DB vorhanden und das eingegebene PAsswort == passwort aus DB, dann war der Login erfolgreich.
		session_start();
		$_SESSION['user_id'] = $results['idBenutzer'];

		header("Location: /dataland/index.php");  	//WICHTIG: An dieser Stelle wird der User zur Seite geleitet falls das Login erfolgreich war
	}
	else {
		$message = 'Email oder Passwort falsch';
	}
endif;

?>



<!DOCTYPE html>
<html>
<head>
	<title>Land.Digital Login</title>
	<link rel="stylesheet" type="text/css" href="Design.css">

</head>
<body>
<div class="wrapper">

	<div class="logo" align="right">
		<a href="index.php"><img class="logo" src="Bilder\Logo.png"></a><!--Durch Klicken auf den Text, wird man zur Startseite weitergeleitet-->
	</div>


	<div class="content" >
		<div><img class="benutzerimg" src="Bilder\Benutzer.png"></div><br><br>

		<div class="login">

			<form action="login.php" method="POST">
				<input class="input" type="text" placeholder="Email" name="emailBenutzer">  	<!-- Boxen für Email und Passwort-Eingabe-->
				<input class="input" type="password" placeholder="Passwort" name="passwort"><br>

				<br>

				<input class="submitButton" type="submit" value="Anmelden"><br><br><br>						 	<!-- Absende/ Bestätigungs Button-->
			</form>


			<span>Passwort vergessen?</span><br>

			<!-- <span><img class="pfeilimg" src="Bilder\Pfeil.png"></span> -->
			<span><a href="register.php">Neu hier?</a></span>  <!-- <span> verwenden um dieses Element besser über CSS anzusprechen-->


			<!-- Ausgabe der Fehlernachricht auf dem Bildschrim-->
			<div class='fehlermeldung_login'>
			<?php if(!empty($message)): ?>
				<p><?= $message ?></p>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
