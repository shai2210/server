<?php
/**
 * Created by PhpStorm.
 * User: shai
 * Date: 22/03/2018
 * Time: 20:32
 */




/*
 * index to read from connector
 * image uploader query
 * API: Pilot sends: drone id, lat,long,time, pic (might be null)
 * API: Manager requests all drone id, lat, long, pic, time
 *
 * Pilot client upload picture to S3 - in return gets a link and stores it in the table alongside with drone id, lat, long, time
 * Pilot client upload verify reasonable lat long
 *
 *
 * */



echo 'test 4';