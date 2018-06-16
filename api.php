<?php

/***
 * api.php
 * $_GET
 * QUERY - ?action=
 * actions:
 * &getAllDrones=true all drones ids coors times and photos
 *
 * api.php
 * $_GET
 * QUERY - ?action=
 * actions:
 * &insertById=true&id=id&lat=lat&long=long&image=url
 *
 */


/**
 * Created by PhpStorm.
 * User: shai
 * Date: 22/03/2018
 * Time: 21:48
 */
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

/* my DB
 * coordination drone_id , time , lat , long
 * drone id  , color  , active , deleted
 * drone_pilot drone_id , pilot_id , active , deleted
 * photo time , drone_id , url
 * pilot id, name
 */
require_once("./includes/queries.php");
require_once("./includes/DBConnector.php");


$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;

$id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : false;
$lat = isset($_REQUEST['lat']) && is_numeric($_REQUEST['lat']) ? $_REQUEST['lat'] : false;
$long = isset($_REQUEST['long']) && is_numeric($_REQUEST['long']) ? $_REQUEST['long'] : false;
$image = isset($_REQUEST['image']) && $_REQUEST['image'] ? $_REQUEST['image'] : null;
$name = isset($_REQUEST['name']) && $_REQUEST['name'] ? $_REQUEST['name'] : null;
$color = isset($_REQUEST['color']) && $_REQUEST['color'] ? $_REQUEST['color'] : null;

$result = null;

if($action) {
    switch ($action){
        case 'insertById':
            if(isset($id,$lat,$long)) {
                insertById($id,$lat,$long, $image);
            }
            else {
                echo 'missing params action or id' . PHP_EOL;
            }

            break;
        case 'insertDrone':
            if(isset($color)){
                insertDrone($color);
            }else {
                echo 'missing color';
            }
            break;

        case 'insertPilot':
            if(isset($name)){
                insertPilot($name);
            }else {
                echo 'missing name';
            }

            break;
        default:
        case 'getAllDrones':
        getAllDrones();
            break;
    }
}

/**
 *
 */
function getAllDrones(){

    $connection = openCon();

    $result = $connection->query(SQL_SELECT_DRONES_DATA);
    $records = [
        "timestamp" => time()
    ];

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            $records['records'][$row['drone_id']]['data'][] = [
                    "time" => $row['time'],
                    "lat" => $row['lat'],
                    "long" => $row['long'],
                    "image" => $row['url']
            ];
            $records['records'][$row['drone_id']]['color'] = $row['color'];
        }
    } else {
        echo "0 results";
    }


    echo json_encode($records);

}

/**
 * @param $id
 * @param $lat
 * @param $long
 * @param null $image
 */
function insertById($id,$lat,$long, $image = null){

    $time = time();
    $time = date("Y-m-d h:m:s",$time);
    $trueCounter = 0;

    $trueCounter += is_null($image) ? 1 : insertToImage($id,$time, $image) ? 1 : 0;

    $trueCounter += insertToCoor($id,$lat,$long,$time) ? 1 : 0;

    $result = $trueCounter > 1 ? true : false;

    $response[] = [
        'success' => $result
    ];

    echo json_encode($response);
}

/**
 * @param $id
 * @param $lat
 * @param $long
 * @param $time
 * @return bool
 */
function insertToCoor($id,$lat,$long,$time){
    $connection = openCon();
    $sql_coordination = "INSERT INTO coordination (`drone_id`, `time`, `lat`, `long`) VALUES (".$id. ","."'".$time."'". ",".$lat."," .$long.")";

    if (mysqli_query($connection, $sql_coordination)) {
        $response = true;
    } else {
        $response = false;
    }
    return $response;
}

/**
 * @param $id
 * @param $time
 * @param $image
 * @return bool
 */
function insertToImage($id, $time, $image){
    $connection = openCon();

    $sql_image = "INSERT INTO photo (`drone_id`, `time`, `url`) VALUES (".$id. ","."'".$time."'". ","."'".$image."'".")";

    if (mysqli_query($connection, $sql_image)) {
        $response = true;
    } else {
        $response = false;
    }
    return $response;
}

/**
 * @param $color
 * @return array
 */
function insertDrone($color){
    $connection = openCon();

    $sql_drone = "INSERT INTO drone (`color`) VALUES ("."'".$color."'".")";
    if (mysqli_query($connection, $sql_drone)) {
        $result = true;
    } else {
        $result = false;
    }
    $response[] = [
        'success' => $result
    ];

    echo json_encode($response);
}



function insertPilot($name){
    $connection = openCon();

    $sql_pilot = "INSERT INTO pilot (`name`) VALUES ("."'".$name."'".")";
    if (mysqli_query($connection, $sql_pilot)) {
        $result = true;
    } else {
        $result = false;
    }
    $response[] = [
        'success' => $result
    ];
    echo json_encode($response);
}

