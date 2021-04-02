<?php
$dir = "csvFiles/";
$files = scandir($dir);
$files = array_diff($files, array('.', '..'));
$array = array();
$a=0;
foreach ($files as $fileName){
    $file = fopen($dir.$fileName,"r");
    $data = fgetcsv($file, 1000, "\t");
    while (($data = fgetcsv($file, 1000, "\t")) !== FALSE)
    {
        $str = mb_convert_encoding($data,  "UTF-8", "UTF-16");
        $array[$a]["meno"]=$str[0];
        $array[$a]["status"]=$str[1];
        $array[$a]["čas"]=$str[2];
        $a=$a+1;
    }
    fclose($file);
}
$temp = array_unique(array_column($array, 'meno'));
$unique_arr = array_intersect_key($array, $temp);

foreach ($unique_arr as $row) {
    $name = $row["meno"];
    $status = $row["status"];
    $time = $row["čas"];
    echo '<tr><td>'.$name.'</td>'.
     '<td>'.$status.'</td>'.
     '<td>'.$time.'</td><tr/>';
}

/*
$file = fopen("contacts.csv","r");
print_r(fgetcsv($file));
fclose($file);*/