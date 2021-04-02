<?php

//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**
//získanie názvov súborov
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

// create curl resource
$ch = curl_init();
$repository = "https://github.com/apps4webte/curldata2021/";
$rawOutput = "https://raw.githubusercontent.com/apps4webte/curldata2021/";

// set url
curl_setopt($ch, CURLOPT_URL, "$repository");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

preg_match_all("!main/[^\s]*?.csv!",$result,$matches);

//pole názvov csv súborov ktoré máme na gitHube
$csvNames = array_unique($matches);

curl_close($ch);

//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**//**
//sťahovanie súborov
foreach ($csvNames[0] as $csvName) {
    $curl = curl_init($rawOutput . $csvName);
    $fileName = 'csvFiles' . strstr($csvName, "/");

    $fp = fopen($fileName, "w");
    curl_setopt($curl, CURLOPT_URL, $rawOutput . $csvName);
    curl_setopt($curl, CURLOPT_FILE, $fp);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

    curl_exec($curl);
    $result2 = curl_exec($curl);
    fwrite($fp, $result2);

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    fclose($fp);
}

