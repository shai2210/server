<?php
/**
 * Created by PhpStorm.
 * User: shai
 * Date: 03/04/2018
 * Time: 23:47
 */

//all queries needs to be define here
//שאילתות שאני צריך:רחפנים להוסיף רחפן להציג את כלל הרחפנים ok
//ok קורדינטות להוסיף קורדינ
//OK ////טייסים להוסיף טייס
//תמונות להוסיף תמונה ולהחזיר תמונה לרחפן כלומר טייס ספציפי להציג את התמונה האחרונה מהרחפן שלו
//משותפות: החזרת כל הקורדינטות עלפי רחפן מסוים ובנוסף את שם הטייס
//OK//להחזיר תמונה על פי לחיצה על קורדינטה

/* my DB
 * coordination drone_id , time , lat , long
 * drone id  , color  , active , deleted
 * drone_pilot drone_id , pilot_id , active , deleted
 * photo time , drone_id , url
 * pilot id, name
 */

require_once("DBConnector.php");

//pilot table
//get all pilots uses for the list in manager screen
define("SQL_SELECT_PILOTS", <<<SQL_SELECT_PILOTS
        SELECT * FROM pilot;
SQL_SELECT_PILOTS
);

define("SQL_SELECT_DRONES_DATA", <<<SQL_SELECT_DRONES_DATA
SELECT coor.drone_id,
	    dr.color,
       coor.time,
       coor.lat,
       coor.long,
       ph.url
FROM drone dr
  JOIN coordination AS coor ON dr.id = coor.drone_id
  LEFT JOIN photo ph ON coor.time = ph.time
WHERE dr.active = 1
AND   deleted = 0
ORDER BY 1,3 ASC;
SQL_SELECT_DRONES_DATA
);
