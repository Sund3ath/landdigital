<?php

echo("test");
$var = $_GET['product'];
echo($var);

include('php_code.php');

$update = true;
$statement = mysqli_query($db, "SELECT * FROM Produkt WHERE idProdukt = '" . $var . "'");

$results = mysqli_fetch_array($statement);
$name = $results['nameProdukt'];
$verfuegbar = $results['anzahlVerfuegbar'];
$preis = $results['Preis'];
$id = $var;


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
        
    
<?php  ?>

        
    
<header>
		<a href="index.php"><img class="LogoLandDigital" src="Bilder\Logo.png"></a>	
		<a href="index.php"><input class="Button" type="button" name="index" ></a>
		<a href="profile_change.php"><input class="Button" type="button" name="profile" ></a>
        <a href="cart.php"><input class="Button" type="button" name="cart" ></a>
		<a href="logout.php"><input class="Button" type="button" name="logout" ></a>
</header>

  <!-- Begrüssung Personalisiert-->
		<div class="CartLogo">
            <h1 style="background: #4c85a8;">Produktbearbeitung</h1>
            <h2 style="background: #8dbad6;"><?php echo $name; ?>!</h2>
		</div>
    
    
<!-- Tabelle: Abfrage der Benutzerdaten-->    
<table>
	<thead>
		<tr>
			<th>Produktname</th>
			<th>Preis</th>
            <th>Verfügbarkeit</th>
		</tr>
	</thead>
    	<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $preis; ?></td>
            <td><?php echo $verfuegbar; ?></td>
		</tr>
</table><br>



<!-- Bearbeitungsformular für das Benutzer Profil -->
    
    <form  action="update_product.php?product=<?php echo $id ?>" method="post">
         <div class="CartLogo">
            <h3 ><?php echo $name; ?> bearbeiten:</h3>
		</div>
          <div class="input-group">
			<label>Produktname</label>
			<input class="input-group" type="text" name="name" value="<?php echo $name; ?>">
		  </div>
          <div class="input-group">
			<label>Preis</label>
			<input type="text" name="preis" value="<?php echo $preis; ?>">
		  </div>
          <div class="input-group">
			<label>Verfuegbarkeit</label>
			<input type="text" name="verfuegbar" value="<?php echo $verfuegbar; ?>">
		  </div>

         <div class="submit-container">
         <input class="submit-button" type="submit" value="absenden" />
        </div>
    </form>
    
    
    </body>  
</html>