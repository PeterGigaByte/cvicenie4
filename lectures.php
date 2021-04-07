<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
include_once 'config/config.php';
$lectures_query = "SELECT * FROM lectures";
$result = mysqli_query($db, $lectures_query);
$lectures = mysqli_fetch_all($result);

for ($i = 0; $i<sizeof($lectures);$i++){
    $date = explode(' ',$lectures[$i][1])[0];
    echo '<th>'.$lectures[$i][0].'  '.$date.'</th>';
}