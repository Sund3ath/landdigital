<<<<<<< HEAD
﻿<?php
session_start();

require 'database.php';

$query="SELECT Produkt1 FROM Bestellung WHERE idBenutzer = '" . $_SESSION['user_id'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$prods = $stmt->fetchAll();
}


$query="SELECT Adresse FROM Benutzer WHERE idBenutzer = '" . $_SESSION['user_id'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressK = $stmt->fetch();					//Adresse des Käufers
}

$cloneK=[];
$cloneK[0]=$adressK[0];
//echo $cloneK[0];



$query="SELECT Benutzer.Adresse FROM Benutzer INNER JOIN Fahrer ON Benutzer.idBenutzer = Fahrer.idBenutzer;";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressF = $stmt->fetchAll();					//Adresse des Fahrers
}
$cloneF=[];
$counter = 0;

foreach($adressF as $banana){
	$cloneF[$counter] = $banana[0];
	$counter = $counter+1;
}

$adressA=[];

for($i=0;$i<count($adressF);$i++){
$a = $adressF[$i];
						//Arbeitsplatz des Fahrers
$query="SELECT Firmenadresse FROM Benutzer where Adresse = '".$adressF[$i][0]."'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressA[$i] = $stmt->fetch();
}
}

$cloneA=[];
$counter = 0;

foreach($adressA as $banana){
	$cloneA[$counter] = $banana[0];
	$counter = $counter+1;
}


//Adresse des Verkäufers
$pr = "('placeholder'";
foreach($prods as $prod)
{
	$pr = $pr .", '". $prod[0]."'" ;
}
$pr = $pr .")";

$query="SELECT DISTINCT Verkaeufer.Adresse FROM Verkaeufer INNER JOIN Produkt ON Verkaeufer.idVerkaeufer = Produkt.idVerkaeufer WHERE nameProdukt IN ". $pr ;
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressV = $stmt->fetchAll();
}
$cloneV=[];
$counter = 0;

foreach($adressV as $banana){
	$cloneV[$counter] = $banana[0];
	$counter = $counter+1;
}
?>

<!DOCTYPE html>
<html>
	<title>Angebotserstellung</title>
	<h1 style="font-size:20px;text-align:center"> Zu erstellende Angebote: </P>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
	<head>
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
			}
			#map {
				position: absolute;
				margin-top: 150px;
				left: 50%;
				margin-left: -448px;
				margin-boo: ( o );
				width: 896px;
				height:504px;
				float: top;
			}
			#output {
				width: 100%;
				text-align: center;
			}
			#pass {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="output"></div>
		<div id="map"></div>
		<script>
			var adresse;
			var adresseKaeufer;
			var outputDiv = document.getElementById("output");
			function test(){
				outputDiv.innerHTML += "<br>hello";
			}
			var uebergabe = "";
			function init(callback) {
				var adressK ="<?php echo $cloneK[0]; ?>";
				adresseKaeufer = adressK;
				var adressF =<?php echo '["' . implode('", "', $cloneF) . '"]'; ?>;
				var adressV = <?php echo '["' . implode('", "', $cloneV) . '"]'; ?>;
				var adressA = <?php echo '["' . implode('", "', $cloneA) . '"]'; ?>;
				var origin = adressF.concat(adressK);
				var destination = adressV.concat(adressA);
				var F;
				var i;
				var counterF = 0;
				var distances = new Array();
				var shortestadress;
				var shortestdistance = 0;
				var map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 51.1657, lng: 10.4515},
					zoom: 10
				});

						var geocoder = new google.maps.Geocoder;
						var service = new google.maps.DistanceMatrixService;
						service.getDistanceMatrix({
						//origins: [adressF[j],adressK],																												//übergabe muss vollständig und als array sein//**
						origins: origin,
						destinations: destination,
						travelMode: google.maps.TravelMode.DRIVING,
						unitSystem: google.maps.UnitSystem.METRIC,
						avoidHighways: false,
						avoidTolls: false
						}, function(response, status){

						for(i = 0; i < adressV.length; i++){
						for(j = 0; j < adressF.length; j++){
						var way1 = response.rows[j].elements[i].distance.value;
						var way2 = response.rows[adressF.length].elements[i].distance.value;
						var way3 = response.rows[adressF.length].elements[adressV.length+j].distance.value;
						var waycomb = response.rows[j].elements[adressV.length+j].distance.value;
						var fahrdistance = (way1+way2+way3)-waycomb;

						if(fahrdistance < shortestdistance || shortestdistance == 0){
							shortestdistance = fahrdistance;
							F = j;
				}
			}
			adresse = adressV[i];
			var k ="F";
			geocodeAddress(geocoder,map,adresse,k);
			outputDiv.innerHTML += "<table class=\"table table-bordered table-hover table-striped\"><tr><th>Fahrer</th><th>Verkaeufer</th></tr></table>";
			//outputDiv.innerHTML += 'Verkauefer: '+adressV[i]+' --- Fahrer: '+adressF[F]+' --- Umweg: '+shortestdistance/1000+' km<br>' ;
			shortestdistance = 0;
			uebergabe += adressV[i] + ":" + adressF[F] + "|";
			}});
			var test;
			}
			//geocodeAddress(geocoder,map,adresseKaeufer,"K");
			function geocodeAddress(geocoder, resultsMap, adress, k){
			var address = adresse;
			//outputDiv.innerHTML += address;
			geocoder.geocode({'address': address}, function(results, status) {
			if (status === 'OK') {
				resultsMap.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
				map: resultsMap,
				label: k,
				animation: google.maps.Animation.DROP,
				position: results[0].geometry.location
				});
			}
			else{
				alert('Geocode was not successful for the following reason: ' + status);
			}
		});
	}

	function sendPHP(){
		var b = uebergabe;
		window.location.href = "sendDATA.php?b=" + b;
	}

		</script>
		<div class = "OrderButton" id="pass">
			<input type="submit" name = "search" value="" onclick="sendPHP()">
		</div>
		<script type="text/javascript"
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGv7Q3OXztVT1Jk5RzvmZ-AAJ_x2BhjCs&callback=init">
		</script>
	</body>
</html>
=======
﻿<?php
session_start();

require 'database.php';

$query="SELECT Produkt1 FROM Bestellung WHERE idBenutzer = '" . $_SESSION['user_id'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$prods = $stmt->fetchAll();
}


$query="SELECT Adresse FROM Benutzer WHERE idBenutzer = '" . $_SESSION['user_id'] . "'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressK = $stmt->fetch();					//Adresse des Käufers
}

$cloneK=[];
$cloneK[0]=$adressK[0];
//echo $cloneK[0];



$query="SELECT Benutzer.Adresse FROM Benutzer INNER JOIN Fahrer ON Benutzer.idBenutzer = Fahrer.idBenutzer;";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressF = $stmt->fetchAll();					//Adresse des Fahrers
}
$cloneF=[];
$counter = 0;

foreach($adressF as $banana){
	$cloneF[$counter] = $banana[0];
	$counter = $counter+1;
}

$adressA=[];

for($i=0;$i<count($adressF);$i++){
$a = $adressF[$i];
						//Arbeitsplatz des Fahrers
$query="SELECT Firmenadresse FROM Benutzer where Adresse = '".$adressF[$i][0]."'";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressA[$i] = $stmt->fetch();
}
}

$cloneA=[];
$counter = 0;

foreach($adressA as $banana){
	$cloneA[$counter] = $banana[0];
	$counter = $counter+1;
}


//Adresse des Verkäufers
$pr = "('placeholder'";
foreach($prods as $prod)
{
	$pr = $pr .", '". $prod[0]."'" ;
}
$pr = $pr .")";

$query="SELECT DISTINCT Verkaeufer.Adresse FROM Verkaeufer INNER JOIN Produkt ON Verkaeufer.idVerkaeufer = Produkt.idVerkaeufer WHERE nameProdukt IN ". $pr ;
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$adressV = $stmt->fetchAll();
}
$cloneV=[];
$counter = 0;

foreach($adressV as $banana){
	$cloneV[$counter] = $banana[0];
	$counter = $counter+1;
}
?>

<!DOCTYPE html>
<html>
	<title>Angebotserstellung</title>
	<h1 style="font-size:20px;text-align:center"> Zu erstellende Angebote: </P>
	<link rel="stylesheet" type="text/css" href="DesignIndex.css">
	<head>
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
			}
			#map {
				position: absolute;
				margin-top: 150px;
				left: 50%;
				margin-left: -448px;
				margin-boo: ( o );
				width: 896px;
				height:504px;
				float: top;
			}
			#output {
				width: 100%;
				text-align: center;
			}
			#pass {
				text-align: center;
			}
		</style>
	</head>
<body>
	<div id="output"></div>
	<div id="map"></div>
	<script>
		var adresse;
		var adresseKaeufer;
		var outputDiv = document.getElementById("output");
		function test(){
			outputDiv.innerHTML += "<br>hello";
		}
		var uebergabe = "";
		function init(callback) {
			var adressK ="<?php echo $cloneK[0]; ?>";
			adresseKaeufer = adressK;
			var adressF =<?php echo '["' . implode('", "', $cloneF) . '"]'; ?>;
			var adressV = <?php echo '["' . implode('", "', $cloneV) . '"]'; ?>;
			var adressA = <?php echo '["' . implode('", "', $cloneA) . '"]'; ?>;
			var origin = adressF.concat(adressK);
			var destination = adressV.concat(adressA);
			var F;
			var i;
			var counterF = 0;
			var distances = new Array();
			var shortestadress;
			var shortestdistance = 0;
			var map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: 51.1657, lng: 10.4515},
				zoom: 10
			});

					var geocoder = new google.maps.Geocoder;
					var service = new google.maps.DistanceMatrixService;
					service.getDistanceMatrix({
					//origins: [adressF[j],adressK],																												//übergabe muss vollständig und als array sein//**
					origins: origin,
					destinations: destination,
					travelMode: google.maps.TravelMode.DRIVING,
					unitSystem: google.maps.UnitSystem.METRIC,
					avoidHighways: false,
					avoidTolls: false
					}, function(response, status){

					for(i = 0; i < adressV.length; i++){
					for(j = 0; j < adressF.length; j++){
					var way1 = response.rows[j].elements[i].distance.value;
					var way2 = response.rows[adressF.length].elements[i].distance.value;
					var way3 = response.rows[adressF.length].elements[adressV.length+j].distance.value;
					var waycomb = response.rows[j].elements[adressV.length+j].distance.value;
					var fahrdistance = (way1+way2+way3)-waycomb;

					//outputDiv.innerHTML += way1+' '+way2+' '+way3+' '+waycomb+' '+fahrdistance+'<br>' ;

					if(fahrdistance < shortestdistance || shortestdistance == 0){
						shortestdistance = fahrdistance;
						F = j;
			}
		}
		adresse = adressV[i];
		var k = F;
		geocodeAddress(geocoder,map,adresse,k);

		outputDiv.innerHTML += 'Verkaeufer: '+adressV[i]+' -- Fahrer: '+adressF[F]+' -- Umweg: '+shortestdistance/1000+' km<br>' ;
		shortestdistance = 0;
		uebergabe += adressV[i] + ":" + adressF[F] + "|";
		}});
		var test;
		}
		//geocodeAddress(geocoder,map,adresseKaeufer,"K");
		function geocodeAddress(geocoder, resultsMap, adress, k){
		var address = adresse;
		//outputDiv.innerHTML += address;
		geocoder.geocode({'address': address}, function(results, status) {
		if (status === 'OK') {
			resultsMap.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
			map: resultsMap,
			label: k,
			animation: google.maps.Animation.DROP,
			position: results[0].geometry.location
			});
		}
		else{
			alert('Geocode was not successful for the following reason: ' + status);
		}
	});
}

function sendPHP(){
	var b = uebergabe;
	window.location.href = "sendDATA.php?b=" + b;
}

	</script>
	<div class = "OrderButton" id="pass">
		<input type="submit" name = "search" value="" onclick="sendPHP()">
	</div>
	<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGv7Q3OXztVT1Jk5RzvmZ-AAJ_x2BhjCs&callback=init">
	</script>
</body>
</html>
>>>>>>> 7c4e245d842d0796c9e116337f9f8c3a74bf29e7
