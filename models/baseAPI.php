<?php

use function PHPSTORM_META\type;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
session_start();
spl_autoload_register(function ($std) {
    // require_once "".$std. ".php";
    require_once "../classess/" . $std . ".php";
});
$action = $_POST['action'];
$tbl = "Category";
function load()
{
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;

    //deleting unnccessary data
    unset($posted_data['action']);
    unset($posted_data['prams']['tbl']);
    unset($posted_data['prams']['priv']);
    unset($posted_data['prams']['type']);
    //setting the additional data
    $posted_data['prams']['user_id'] = $user_id;
    $posted_data['prams']['type'] = $_POST['prams']['type'];
    // var_dump($posted_data);

    $std_edit = new Base();
    $std_edit->store_proc($posted_data['prams']);
}

function insert()
{
    $obj = new Base();
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;
    $tbl = $_POST['tbl'];
    // setting your additional data to an array
    $priv =  (isset($_POST['priv'])) && $_POST['priv'] != 'undefined' ? $_POST['priv'] : "";
    $target_id = array_keys($_POST)[0];
    $id = $obj->generate_id($target_id, $tbl, $priv);
    // echo "id: ".$id;
    $array_data = ['proc_name' => $_POST['proc_name']];
    //set id to post dat
    $posted_data[$target_id] = $id;


    //deleting unnccessary data
    unset($posted_data['type']);
    //setting the additional data
    if(isset($_POST['user_id'])){
        $posted_data['created_user'] = $user_id;
    }else{
        $posted_data['user_id'] = $user_id;
    }
    
    $posted_data['type'] = $_POST['type'];
    // iff isset post of member
    // if (isset($_POST['member'])) {
    //     $posted_data['member'] =  implode(',', $_POST['member']);
    // }
    foreach ($posted_data as $key => $value) {
        if (is_array($value)) {
            $posted_data[$key] =  implode(',', $_POST[$key]);
        }
    }
   
    // creating obj from the class
    $Std_insert = new Base();
    // var_dump(Rearrange_post($array_data,$posted_data));
    $Std_insert->store_proc(Rearrange_post($array_data, $posted_data));
}

function loop_insert()
{
    $obj = new Base();
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;
    $tbl = $_POST['tbl'];
    // setting your additional data to an array
    $priv =  (isset($_POST['priv'])) && $_POST['priv'] != 'undefined' ? $_POST['priv'] : "";
    $target_id = array_keys($_POST)[0];
    $id = $obj->generate_id($target_id, $tbl, $priv);
    // echo "id: ".$id;
    $array_data = ['proc_name' => $_POST['proc_name']];
    //set id to post dat
    $posted_data[$target_id] = $id;
    
    $check_in_array = check_loop($posted_data);
    $Std_insert = new Base();
    if ($check_in_array['status']) {
        $res = 0;
        $fields = [];
        for ($i = 0; $i < $check_in_array['len']; $i++) {
            foreach ($posted_data as $key => $value) {
                if (is_array($value)) {
                    $fields[$key] = $value[$i];
                } else {
                    $fields[$key] = $value;
                }
            }
            unset($fields['type']);
            if(isset($_POST['user_id'])){
                $posted_data['created_user'] = $user_id;
            }else{
                $posted_data['user_id'] = $user_id;
            }
            $fields['type'] = $_POST['type'];
            //    var_dump($fields);
            // creating obj from the class
            $res = $Std_insert->store_proc(Rearrange_post($array_data, $posted_data),false);
        }
        http_response_code(200);
        $result_data = array("message" => "Data Has been Inserted Successfully");
        echo json_encode($result_data);
    }
}

function check_loop($data)
{
    $res = array("status" => false, "len" => 0);
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $res['status'] = true;
            $res['len'] = count($value);
        }
    }

    return $res;
}
// generate id function
function generate_tbl_id($tbl, $priv, $target_id)
{
    $priv = $priv;
    $obj = new Base();
    $generated_column_id =  $obj->generate_id($target_id, $tbl, $priv);
    return $generated_column_id;
}
// rearrange posted data
function Rearrange_post($array_data, $posted_data)
{
    $user_id = $_SESSION['user_id'];
    // inserting data at the start of the posted data array
    $post = $posted_data;
    $post = array_merge($array_data, $post);
    //deleting unnccessary data
    unset($post['action']);
    unset($post['tbl']);
    unset($post['priv']);
    unset($post['session_id']);

    return $post;
}
function update()
{
    // extract($_POST);
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;
    $array_data = ['proc_name' => $_POST['proc_name']];
    //deleting unnccessary data
    unset($posted_data['type']);
    //setting the additional data
    if(isset($_POST['user_id'])){
        $posted_data['created_user'] = $user_id;
    }else{
        $posted_data['user_id'] = $user_id;
    }
    $posted_data['type'] = $_POST['type'];

    // var_dump(Rearrange_post($array_data,$posted_data));
    // creating obj from the class
    $Std_insert = new Base();
    $Std_insert->store_proc(Rearrange_post($array_data, $posted_data));
}
function fetch()
{
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;

    //deleting unnccessary data
    unset($posted_data['action']);
    unset($posted_data['prams']['tbl']);
    unset($posted_data['prams']['priv']);
    unset($posted_data['prams']['type']);
    //setting the additional data
    $posted_data['prams']['user_id'] = $user_id;
    $posted_data['prams']['type'] = $_POST['prams']['type'];
    // var_dump($posted_data);

    $std_edit = new Base();
    $std_edit->store_proc($posted_data['prams']);
}
function fill()
{
    extract($_POST);
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;
    //deleting unnccessary data
    unset($posted_data['action']);
    unset($posted_data['prams']['tbl']);
    unset($posted_data['prams']['priv']);
    unset($posted_data['prams']['type']);
    //setting the additional data
    $posted_data['prams']['user_id'] = $user_id;
    $posted_data['prams']['type'] = $_POST['prams']['type'];
    // $type = 'Fetch';
    $std_edit = new Base();
    // var_dump($posted_data);
    $std_edit->store_proc($posted_data['prams']);
}
function del()
{

    extract($_POST);
    $user_id = $_SESSION['user_id'];
    $posted_data = $_POST;
    //deleting unnccessary data
    unset($posted_data['action']);
    unset($posted_data['prams']['tbl']);
    unset($posted_data['prams']['priv']);
    unset($posted_data['prams']['type']);
    //setting the additional data
    $posted_data['prams']['user_id'] = $user_id;
    $posted_data['prams']['type'] = $_POST['prams']['type'];
    // var_dump($posted_data);
    // $type = 'Fetch';
    $std_edit = new Base();
    $std_edit->store_proc($posted_data['prams']);
}

function img(){
    extract($_POST);
    $obj = new Base();
    $name = $_FILES['file']['name'];
    $user_id = $_POST['id'];
    $obj->img_update($user_id,"user_id",$name,"users","img_profile");
}


$con = new Base();
if (isset($action)) {
    $action();
} else {
    http_response_code(400);
    $result_data = array("message" => "you don't have authentication !");
    echo json_encode($result_data);
}
