<?php

//pulls the latest repo changes to the remote server
//http://18.207.210.26/pull.php?key=shaimalka123 from browser


define('PRIVATE_KEY', 'shaimalka123');

if ($_SERVER['REQUEST_METHOD'] === 'GET'
    && $_REQUEST['key'] === PRIVATE_KEY)
{
    echo 'pulling';
    echo shell_exec("sudo su");
    echo shell_exec("whoami");
    echo shell_exec("git pull");
}
else echo 'error';