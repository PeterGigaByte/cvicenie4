<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);


header('Content-Type: text/html; charset=UTF-8');
$dir = "csvFiles/";
$files = scandir($dir);
$files = array_diff($files, array('.', '..'));
//pole pre zapisovanie údajov
//$users =  array();
//$final = array();
//$a=0;
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
        //$user = array('name' => $name, 'status' => $status, 'date' => $date);
        /*
        $array[$a]["meno"]=$data[0];
        $array[$a]["status"]=$data[1];
        $array[$a]["čas"]=$data[2];
        $a = $a + 1;
        */
    }
    //echo $pred.'. ';
    $pred = 1 + $pred;
    fclose($file);


}
/*
$temp = array_unique(array_column($array, 'meno'));
$unique_arr = array_intersect_key($array, $temp);
//výpis do tabuľky
foreach ($unique_arr as $row) {
    $name = $row["meno"];
    $status = $row["status"];
    $time = $row["čas"];
    echo '<tr>
                <td>'.$name.'</td>'.
                '<td>'.$status.'</td>'.
                 '<td>'.$time.'</td>
         </tr>';

}
*/

/*
$file = fopen("contacts.csv","r");
print_r(fgetcsv($file));
fclose($file);*/