 <?php
 $servername = "inf-education-35.umwelt-campus.de";
 $username = 'ko_landdigital';
 $password = 'BPL9qJyjfqMZHCAt';

 try {
     $conn = new PDO('mysql:host=inf-education-35.umwelt-campus.de;dbname=LandDigital', $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully" . "<br>";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
