<?php
/**
 * Created by PhpStorm.
 * User: shai
 * Date: 22/03/2018
 * Time: 21:48
 */

header('Content-type: application/json');

/* my DB
 * coordination drone_id , time , lat , long
 * drone id  , color  , active , deleted
 * drone_pilot drone_id , pilot_id , active , deleted
 * photo time , drone_id , url
 * pilot id, name
 */
require_once("queries.php");
require_once("DBConnector.php");
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : false;
$result = null;

if($action) {
    switch ($action){
        case 'getById':
            if(isset($id)) {
                $response = getDroneById();
            }
            else {
                echo 'missing params action or id' . PHP_EOL;
            }

            break;
        default:
        case 'getAllDrones':
            $response = getAllDrones();
            break;
    }
}

function getAllDrones(){

    $connection = openCon();

    $result = $connection->query(SQL_SELECT_DRONES);
    $records = [];

    if ($result->num_rows > 0) {
        // output data of each row

        while($row = $result->fetch_assoc()) {
            $records[] = [
                'id' => $row['id'],
                'color' => $row['color']
            ];        }
    } else {
        echo "0 results";
    }


    //var_dump($records);
    echo json_encode($records);
    //return $records;

}

//
//function getDroneRouteById($query){
//    $connection = openCon();
//    $stmt = $connection->prepare($query);
//    $result = $stmt->execute();
//    closeCon($connection);
//
//    return $result;
//}
//
//function getPhotoById($query){
//    $connection = openCon();
//    $stmt = $connection->prepare($query);
//    $result = $stmt->execute();
//    closeCon($connection);
//    return $result;
//}
//
////INSERT INTO drone(id,color,active,deleted)
//function insertDrone($query,$id,$color,$active,$del){
//    $con = openCon();
//    $stmt = $con->prepare($query);
//    $stmt->bind_param("isii",$currId,$currColor,$currActive,$currDel);
//    $currId=$id;
//    $currColor = (string)$color;
//    $currActive = $active;
//    $currDel = $del;
//    $result = $stmt->execute();
//    $stmt->close();
//    closeCon($con);
//}
//
////INSERT INTO photo (time , drone_id , url)
//function insertPhoto($query,$time,$drone_id,$url){
//    $con = openCon();
//    $stmt = $con->prepare($query);
//    $stmt->bind_param("sis",$currTime,$currDrone , $curUrl);
//    $currTime=$time;
//    $currDrone = $drone_id;
//    $curUrl = $url;
//    $result = $stmt->execute();
//    $stmt->close();
//    closeCon($con);
//}
//
////INSERT INTO coordination (drone_id , time , lat , long)
//function insertCoordination($query,$time,$drone_id,$lat,$long){
//    $con = openCon();
//    $stmt = $con->prepare($query);
//    $stmt->bind_param("iidd",$currDrone,$currTime, $curLat, $curLong);
//    $currTime=$time;
//    $currDrone = $drone_id;
//    $curLat = $lat;
//    $curLong = $long;
//    $result = $stmt->execute();
//    $stmt->close();
//    closeCon($con);
//}
//
//function getCoordination($query,$droneId){
//    $con = openCon();
//    $stmt = $con->prepare($query);
//    $stmt->bind_param("i",$currDrone);
//    $stmt->execute();
//    $stmt->fetch();
//    echo $currDrone;
//    $stmt->close();
//    closeCon($con);
//}
//
//
//function getDroneById($drone_id) {
//    $con = openCon();
//    $stmt = $con->prepare($query);
//    $stmt->bind_param("i",$currDrone);
//    $stmt->execute();
//    $stmt->fetch();
//    echo $currDrone;
//    $stmt->close();
//    closeCon($con);
//}