
<?php
session_start();

require 'database.php';

if(isset($_FILES["pic"]["name"])){
$target_dir = "Bilder/";
$target_file = $target_dir . basename($_FILES["pic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["pic"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["pic"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}}

if(!empty($_POST['nameProdukt'])): 
	
	$query="SELECT vnameBenutzer,nameBenutzer FROM Benutzer WHERE idBenutzer = '" . $_SESSION['user_id'] . "'";
	$stmt = $conn->prepare($query);
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
	$name = $stmt->fetchAll();
	//$fullname = implode(" ",$name[0]);
	$fullname = ""; 
	$fullname = $name[0][0] . " " . $name[0][1];
	}	
	
	$sql = "INSERT INTO Produkt (Preis, nameProdukt, verkaeuferProdukt, idVerkaeufer, Vorschau) VALUES (:Preis, :nameProdukt, :verkaeuferProdukt, :user_id, :Vorschau )"; // Zeile 8 =Query  //Code muss an jede Datenband angepasst werden  ":"steht für column
	$stmt =  $conn->prepare($sql);  
	
	$stmt->bindParam(':Preis', $_POST['Preis']);
	$stmt->bindParam(':nameProdukt', $_POST['nameProdukt']);
	$stmt->bindParam(':verkaeuferProdukt', $fullname);
	$stmt->bindParam(':user_id', $_SESSION['user_id']);
	$stmt->bindParam(':Vorschau', $target_file);
	//$stmt->bindParam(':user_id', $target_file);
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
	<title>Land.Digital Produktregistrierung</title>
	<link rel="stylesheet" type="text/css" href="Design.css">
	
</head>
<body>
		
		<div class="logo" align="right">
			<a href="index.php"><img class="logo" src="Bilder\Logo.png"></a><!--Durch Klicken auf den Text, wird man zur Startseite weitergeleitet-->
		</div>
		 
		<div class="content" >
			
			
			<div><img class="wagenimg" src="Bilder\Einkaufswagen.png"></div> <br>
			<!--<h1>Registrieren</h1>-->
		
				
					<!-- Ausgabe der (Fehler)-Nachricht auf dem Bildschrim -->
				<?php if(!empty($message)): ?>
					<p><?= $message ?></p>  
				<?php endif; ?> 
		
		
			<form action="produktregister.php" method="POST" enctype="multipart/form-data"> <!--action="register.php" bedeutet: Post to register.php -->
			<div class="teil1">
			<input class="input" type="text" placeholder="Produktname" name="nameProdukt">
			<input class="input" type="text" placeholder="Preis" name="Preis">
			<!--<input class="input" type="password" placeholder="Passwort wiederholen" name="confirm_passwort"> -->
			</div>
			<div class="teil2">
			<input type="file" name="pic" id="pic" placeholder="Voschaubild">
			</div>

			<br>
			<input class="submitButton" type="submit" value="Registrieren">	<br><br><br>	<!-- Absende/ Bestätigungs Button, Value gibt die Beschriftung des Buttons an -->
			</form>
		</div>
		

</body>
</html>