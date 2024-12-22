<?php
session_start();
spl_autoload_register(function($std)
{
    // require_once "".$std. ".php";
    require_once "../classess/" . $std . ".php";
});
$action = $_POST['action'];
$tbl = "users";

function login()
{
    extract($_POST);
   $ob = new Base();
   $ob->login($user_name,$password);
}



if (isset($action)) {
    $action($tbl);
}
