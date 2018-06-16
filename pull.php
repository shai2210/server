<?php

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