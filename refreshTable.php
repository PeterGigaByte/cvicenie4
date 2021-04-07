<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

include_once 'config/config.php';
include_once 'config/config2.php';
$lectures_query = "SELECT MAX(id) FROM lectures";
$result = mysqli_query($db, $lectures_query);
$lectures = mysqli_fetch_array($result);

$people = array();


function searchUserActions($keyWord,$lectures,$array,$dbh){
    //vytvorenie pola ludi
    if($keyWord=="people") {
        for ($i = 1; $i<=$lectures[0];$i++){
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
            for ($i = 1; $i<=$lectures[0];$i++){
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
        $time = array();
        foreach($array as $person) {
            for ($i = 1; $i <= $lectures[0]; $i++) {
                $users_actions_query = $dbh->query("SELECT * FROM users_actions WHERE lecture_id='$i' AND meno='$person[0]'");
                $users_actions = $users_actions_query->fetchAll(PDO::FETCH_ASSOC);
                $time = 0;
                foreach($users_actions as $user_action){
                    if($user_action["action"]=="Joined"){
                        $parseDateTime = explode(' ',$user_action["timestamp"]);
                        $time = $time + minutes($parseDateTime[1]);
                    }
                    else{
                        $parseDateTime = explode(' ',$user_action["timestamp"]);
                    }
                }
            }
        }
    }
    //vytvorenie stráveného času


    return $array;
}
$people = searchUserActions("people",$lectures,$people,$dbh);
$attendees = searchUserActions("attendees",$lectures,$people,$dbh);


for ($i = 0; $i<sizeof($people);$i++){
    echo '<tr>';
    echo '<td>'.$people[$i][0].'</td>';
    echo '<td>'.$attendees[$i].'</td>';
    echo '<td></td>';
    echo '</tr>';
}