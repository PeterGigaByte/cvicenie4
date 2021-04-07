<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

include_once 'config/config.php';
include_once 'config/config2.php';
$lectures_query = "SELECT MAX(id) FROM lectures";
$result = mysqli_query($db, $lectures_query);
$lectures = mysqli_fetch_array($result);

$people = array();


function searchUserActions($keyWord,$array2,$array,$dbh){
    //vytvorenie pola ludi
    if($keyWord=="people") {
        for ($i = 1; $i<=$array2[0];$i++){
            $users_actions_query = $dbh->query("SELECT * FROM users_actions WHERE lecture_id='$i'");
            $users_actions = $users_actions_query->fetchAll(PDO::FETCH_ASSOC);
                foreach($users_actions as $user_action){
                        if (!in_array(array($user_action["name"]), $array)) {
                            array_push($array, array($user_action["name"]));
                        }
                }
        }
    }
    //vytvorenie pola účastí
    if($keyWord=="attendees"){
        $attendees = array();
        foreach($array as $person){
            $attend = 0;
            for ($i = 1; $i<=$array2[0];$i++){
                $users_actions_query = $dbh->query("SELECT * FROM users_actions WHERE lecture_id='$i'");
                $users_actions = $users_actions_query->fetchAll(PDO::FETCH_ASSOC);
                foreach($users_actions as $user_action){
                    if ($person[0]==$user_action["name"] && $user_action["action"]=="Joined" ) {
                            $attend++;
                            break;
                    }
                }
            }
            array_push($attendees,$attend);
        }
        return $attendees;
    }
    if($keyWord=="time"){
        $timeArray = array();
        foreach($array as $person) {
            $people_at = array();
            for ($i = 1; $i <= $array2[0]; $i++) {
                $users_actions_query = $dbh->query("SELECT * FROM users_actions WHERE lecture_id='$i' AND name='$person[0]'");
                $users_actions = $users_actions_query->fetchAll(PDO::FETCH_ASSOC);
                $time = 0;
                foreach($users_actions as $user_action){
                    if($user_action["action"]=="Joined"){
                        $parseDateTime = explode(' ',$user_action["timestamp"]);
                        $time = $time + minutes($parseDateTime[1]);
                    }
                    else{
                        $parseDateTime = explode(' ',$user_action["timestamp"]);
                        $time = $time - minutes($parseDateTime[1]);
                    }
                }
                $minutes = round(abs($time),2);
                array_push($people_at,$minutes);
            }

            array_push($timeArray,$people_at);
        }
        return $timeArray;
    }
    if($keyWord=="time_full"){
        $timeArray_full = array();
        for ($i = 0; $i<sizeof($array);$i++){
            $time_full = 0;
            foreach ($array2[$i] as $time){
                $time_full = $time + $time_full;
            }
            array_push($timeArray_full,$time_full);
        }

        return $timeArray_full;
    }
    //vytvorenie stráveného času


    return $array;
}
function minutes($time){
    $time = explode(':', $time);
    return ($time[0]*60) + ($time[1]) + ($time[2]/60);
}
$people = searchUserActions("people",$lectures,$people,$dbh);
$attendees = searchUserActions("attendees",$lectures,$people,$dbh);
$time = searchUserActions("time",$lectures,$people,$dbh);
$time_full = searchUserActions("time_full",$time,$people,$dbh);

for ($i = 0; $i<sizeof($people);$i++){
    $name =explode(" ", $people[$i][0]);
    $surname='';
    for ($w = 1; $w<sizeof($name);$w++){
        $surname = $name[$w];
    }
    echo '<tr>';
    echo '<td>'.$name[0].'</td>';
    echo '<td>'.$surname.'</td>';
    for ($j = 0; $j < $lectures[0]; $j++) {
        if($time[$i][$j] < 132){
        echo '<td>'.$time[$i][$j].'</td>';}
        else{
            echo '<td class="not-left">'.$time[$i][$j].'</td>';
        }
    }
    echo '<td>'.$attendees[$i].'</td>';

    echo '<td>'.$time_full[$i].'</td>';



    echo '</tr>';
}