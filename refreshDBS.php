<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

$dir = "csvFiles/";
$files = scandir($dir);
$files = array_diff($files, array('.', '..'));

//prechádzanie súborov
$pred = 1;
include_once "config/config.php";

$truncateTable = "TRUNCATE TABLE users_actions";
mysqli_query($db, $truncateTable);
$truncateTable = "TRUNCATE TABLE lectures";
mysqli_query($db, $truncateTable);
foreach ($files as $fileName){
    $file = fopen($dir.$fileName,"r");
    $data = fgetcsv($file, 0, "\t");
    while (($data = fgetcsv($file, 0, "\t")) !== FALSE)
    {
        $name = $data[0];
        $action = $data[1];
        if($pred==3){
            $timestamp = date('Y-m-d H:i:s',date_create_from_format('m/d/Y, H:i:s A',$data[2])->getTimestamp());
        }else{
            $timestamp = date('Y-m-d H:i:s',date_create_from_format('d/m/Y, H:i:s',$data[2])->getTimestamp());
        }
        $lecture_check_query = "SELECT timestamp FROM lectures WHERE timestamp ='$timestamp' LIMIT 1";
        $result = mysqli_query($db, $lecture_check_query);
        $lecture = mysqli_fetch_assoc($result);
        if(!$lecture){
            $query = "INSERT INTO lectures (id, timestamp ) 
  			  VALUES('$pred', '$timestamp')";
            mysqli_query($db, $query);
        }
        $lecture_id = $pred;
        $query = "INSERT INTO users_actions (lecture_id, name, action,timestamp ) 
  			  VALUES('$lecture_id', '$name', '$action','$timestamp')";
        mysqli_query($db, $query);

        print_r($data);
        echo '<br>';

    }
    $pred = 1 + $pred;
    fclose($file);
}
