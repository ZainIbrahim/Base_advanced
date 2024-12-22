<?php
session_start();
spl_autoload_register(function($std)
{
    // require_once "".$std. ".php";
    require_once "../classess/" . $std . ".php";
});
$action = $_POST['action'];
$tbl = "auth";
function load($tbl)
{
    $user_id = $_SESSION['user_id'];
    $fields = [
        "menu_id" => "''",
        "sub_id" => "''",
        "action_id" => "''",
        "user_id" => "'$user_id'",
        "auth_user" => "''",
        "created_date" => "''",
        "type"=>"'select'",
    ];
    $std_select = new Base();
    $std_select->selectAllWithfill("usp_auth",$fields);
}

function selection($tbl)
{
    // $user_id = 1;
    $user_id = $_SESSION['user_id'];
    $fields = [
        "auth_user"=>"'$user_id'",
    ];
    $std_select = new Base();
    $std_select->selectAllWithfill("usp_select_nav",$fields);
}


function insert($tbl)
{
    $result_data = array();
    $result = "";
    extract($_POST);
    $id =[
        "auth_user" => $user_id
    ];
    $std_del = new Base();
    $std_del->LoopDelete($id,$tbl);
    if(!isset($_POST['actions'])){
        $result_data = array("status" => true, "message" => "User has been revoked authority.");
    }
    else{

        for($i = 0; $i<count($actions); $i++ ){
            $id = $_SESSION['user_id'];
        // $id = 1;
            $date = date('Y-m-d');
            $fields = [
                "menu_id" => "'$menus[$i]'",
                "sub_id" => "'$sub_menus[$i]'",
                "action_id" => "'$actions[$i]'",
                "user_id" => "'$id'",
                "auth_user" => "'$user_id'",
                "created_date" => "'$date'",
                "type"=>"'dml'",
            ];
            $Std_insert = new Base($tbl);
            $result = $Std_insert->dml_loop("usp_auth",$fields);
    }
}
if($result == 1){
    $result_data = array("status" => true, "message" => "User has been granted Authority.");
}

echo json_encode($result_data);
}

function fetch_actions($tbl)
{
    extract($_POST);
    $idL =[
        "auth_user" => $user_id
    ];
    $std_edit = new Base();
    $std_edit->fetch_actions($idL,$tbl);
}

function fill($tbl)
{
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    $std_select = new Base();
    $feilds = [
        "user_id" =>"'$user_id'",
        "user_name" =>"'$user_id'"
    ];
    $std_select->fill("users",$feilds);
}



$con = new Base();
if (isset($action) && isset($_SESSION['user_id']) && isset($_SESSION['System']) && $_SESSION['System'] == $con->Sysname) {
    $action($tbl);
}else{
    http_response_code(400);
    $result_data = array("message" =>"you don't have authentication !");
    echo json_encode($result_data);
}
