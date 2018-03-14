<!DOCTYPE html>
<html>
<head>
    <title>Prihlásenia</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<a class="buttonLike" href="index.php">Späť</a><br>
<?php
$configs = include('config.php');
$conn = mysqli_connect($host, $dbuser, $password, $dbname);

$id = $_GET["id"];

$query = "SELECT * FROM logged WHERE user_id = '$id';";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    echo "<a>Boli ste prihlásený ".$row['datetime'];
    if($row['type'] == 1) {
        echo " z registrovaného účtu</a><br>";
    }
    elseif ($row['type'] == 2) {
        echo " z google účtu</a><br>";
    }
    elseif ($row['type'] == 3) {
        echo " zo školského účtu</a><br>";
    }
}

$query = "SELECT type FROM logged";
$result = mysqli_query($conn, $query);
$type1 = 0;
$type2 = 0;
$type3 = 0;
while ($row = mysqli_fetch_array($result)) {
    if ($row['type'] == 1) {
        $type1++;
    }
    elseif ($row['type'] == 2) {
        $type2++;
    }
    elseif ($row['type'] == 3) {
        $type3++;
    }
}
$sum = $type1 + $type2 + $type3;
echo "<br><a>Celkovo prihlásení ".$sum." a z toho:<br>";
echo "</a>Registrovaní: ".$type1." (".($type1/$sum)."%)<br>";
echo "</a>Google: ".$type2." (".($type2/$sum)."%)<br>";
echo "</a>LDAP: ".$type3." (".($type3/$sum)."%)<br>";
?>
</body>
</html>