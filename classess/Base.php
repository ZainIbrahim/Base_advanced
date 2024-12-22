<?php
header("Content-Type: application/json");
// session_start();
class Base extends Dbase
{
 //sms details creating
 public function sms_details($pr,$fields)
 {
     $implode = implode(",",$fields);
     $result_data = array();
     $query = "EXEC $pr $implode";
     $stat = $this->conn()->prepare($query);
     $stat->execute();
     if ($stat) {
        
            // $result_data = array("status" => true, "message" => " Data has been processed successfully");
            return 1;
         
     } else {
         $result_data = array("status" => false, "message" =>$this->conn()->pdo->errorInfo());
        // return 0;
     }
     // return $test;

     echo json_encode($result_data);
 }

 public $defualt_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImZhcmF4c2FuZSIsImV4cCI6MTY0MTM4NjAxNX0.nfIrBjtV8oAG432C0cQinQuPadHjepykU8FDBWIM7LI";
 public $Sysname = "Base";
 //dynamic Create and Update Procedure
 public function dml($pr,$fields)
 {  
     try {
        $implode = implode(",",$fields);
        $result_data = array();
        $query = "EXEC $pr $implode";
        $stat = $this->conn()->prepare($query);
        $stat->execute();
        if ($stat) {
            http_response_code(200);
            $result_data = array("message" => "Data has been executed successfully");
        }else{
            http_response_code(400);
            $result_data = array("message" =>"Data has not been executed successfully"); 
        }  
    } catch (PDOException $ex) {
        http_response_code(400);
        $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
        // $this->conn()->pdo->errorInfo()
    }
    
    echo json_encode($result_data);
 }
 // all Insert and Update Function
 public function store_proc($posted_data)
 {
    $type =  $posted_data['type'];
    try {
    $result_data = array();
     $USERNAME = $posted_data['user_id'];
    //  $sql_param = "SET NOCOUNT ON; SET ANSI_WARNINGS ON;";
     $sql_param = "exec ";
     $i = 0;
     // $sth->execute(array(':calories' => $calories, ':colour' => $colour));
     foreach ($posted_data as $key => $val) {
         if ($i == 0) {
             //first loop
             $sql_param .= $val . " ";
             // $bindpram[]=array(":$key => $val");
         } elseif ($i == count($posted_data) - 1) {
            $sql_param .= "'" . $val . "';";
            // if($type != 'dml'){
                
            // }else{
            //       $sql_param .= "'" . $val . "',";
            // //  $sql_param .= "'" . $USERNAME . "';";
            //  // $bindpram.= ":$key => $val";
            // }
           
         } else {
             $sql_param .= "'" . $val . "',";
             // $bindpram .= ":$key => $val,";
         }
         $i++;
     }
     //   print_r($sql_param);
    //  echo $sql_param;
     $stmt = $this->conn()->prepare($sql_param);
     $stmt->execute();
     if ($stmt) {
        if($type =='dml'){

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = $row['messge'];
            }
            http_response_code(200);
            $result_data = array("message" => $data); 
            $this->conn = null;
        }else if($type =='Delete'){

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = $row['messge'];
            }
            http_response_code(200);
            $result_data = array("message" => $data); 
            $this->conn = null;
        }else{
            // seleting data functions for fetch,select,fill and etc
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }   
            http_response_code(200);
            $result_data = array("message" => $data); 
            $this->conn = null;
        }
        
       
     } else {
        http_response_code(400);
        $result_data = array("message" =>"Data Has Not Been Executed/Not Found Successfully"); 
        $this->conn = null;
     }
    } catch (PDOException $ex) {
        http_response_code(400);
        $result_data = array("title"=>"Error occured Please try again!","message" =>$ex->getMessage());
        // $this->conn()->pdo->errorInfo()
    }
    
    echo json_encode($result_data);
 } // ./ all Insert and Update Function

 //dynamic Create and Update Procedure with loop
 public function dml_loop($pr,$fields)
 {
    
     try {
        $implode = implode(",",$fields);
        $result_data = array();
        $query = "EXEC $pr $implode";
        $stat = $this->conn()->prepare($query);
        $stat->execute();
        if ($stat) { 
            http_response_code(200);
            return 1;   
        }else{
            http_response_code(400);
            $result_data = array("message" =>"Data has not been executed successfully"); 
        } 
    } catch (PDOException $ex) {
        http_response_code(400);
        $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
        // $this->conn()->pdo->errorInfo()
    }
     echo json_encode($result_data);
 }


 // dynamic insert
    public function insert($fields,$tbl)
    {
       
        try {
            $implode_fields = implode(",", array_keys($fields));
            $implode_fields_place = implode(",:", array_keys($fields));
            // var_dump($implode_fields);
            $sql = "INSERT INTO $tbl($implode_fields) VALUES (:" . $implode_fields_place . ")";
            // echo $sql;
            $stat = $this->conn()->prepare($sql);
            foreach ($fields as $key => $value) {
                $stat->bindValue(":" . $key, $value);
            }
            $result_data = array();
            $result = $stat->execute();
            if ($result) {
                http_response_code(200);
                $result_data = array("message" => "Data has been saved successfully.");
            } else{
                http_response_code(400);
                $result_data = array("message" =>"Data Not been saved successfully"); 
            } 
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
           
        }
        echo json_encode($result_data);
    }
     // dynamic update
    public function update($fields, $ids,$tbl)
    {
        try {
            $id = implode(",",$ids);
            $column = implode(",",array_keys($ids));
            $st = "";
            $counter = 1;
            $totalFields = count($fields);
            foreach ($fields as $key => $value) {
                if ($counter === $totalFields) {
                    $set = "$key = :" . $key;
                    $st = $st . $set;
                } else {
                    $set = "$key = :" . $key . ", ";
                    $st = $st . $set;
                    $counter++;
                }
            }


            $sql = "";
            $sql .= "UPDATE $tbl SET ".$st;
            $sql .= " where $column = :".$column."";
            // var_dump($fields);
            $stmt = $this->conn()->prepare($sql);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':'. $key, $value);
            }
            $stmt->bindValue(":".$column, $id);
            // var_dump($stmt);
            $stmtExec = $stmt->execute();

            // if($stmtExec){
            // header('Location: index.php');
            // }
            $result_data = array();
            if ($stmtExec) {
                // echo "Inserted success";
                return 1;
            }else{
                http_response_code(400);
                $result_data = array("message" =>"Data Not been Updated successfully"); 
            }
        }catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
           
        }
        // var_dump($fields);
        echo json_encode($result_data);
    }
    //dynamic select All with proceduces
    public function selectAllWithfill($pr,$fields)
    {
        try {
            $implode = implode(",",$fields);
            $result_data = array();
            $query = "EXEC $pr $implode";
            $stat = $this->conn()->prepare($query);
            $stat->execute();
            if ($stat) {
                if($stat->rowCount()){
                    while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    http_response_code(200);
                    $result_data = array("message" => $data);
                }
                else {
                    http_response_code(400);
                    $result_data = array("message" => "Data Not Found");
                }
            }
            }  catch (PDOException $ex) {
                http_response_code(400);
                $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
                // $this->conn()->pdo->errorInfo()
            }
        
        // return $test;

        echo json_encode($result_data);
    }
   // getting any column oftable with filter
   public function get_column($idl,$fields,$tbl)
    {  
        try {
            $data = [];
            $implode_id = implode(",",array_keys($idl));
            $column = implode(",",array_keys($fields));
            $id = implode(",",$idl);
            $query = "select $column from $tbl where $implode_id = :id";
            $stat = $this->conn()->prepare($query);
            $stat->execute([':id' => $id]);
            if ($stat) {
                $data = [];
                if($stat->rowCount()){
                    while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    http_response_code(200);
                    return $data;
                }
                else {
                    http_response_code(400);
                    $result_data = array("message" =>"Email is not Found");
                }
             }
        }catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }
        echo json_encode($result_data);
   }

     // dynamic Generate id
    public function generate_id($id,$tbl,$priv)
    { 
        try {
            $result_data = array();
            $query = "select $id from $tbl order by $id asc";
            $stat = $this->conn()->prepare($query);
            $stat->execute();
            if ($stat) {
               if($stat->rowCount()){
                   $user_id = '';
                    while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                        $user_id= $row[$id];
                    }
                    $user_id ++;
                } else {
                    $user_id = $priv."1";
                }
            }
            return $user_id;
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }
          
    }

     // fetch user_actions
    public function fetch_actions($idl,$tbl)
    {   
        try {
            $data = [];
            $implode_id = implode(",",array_keys($idl));
            $id = implode(",",$idl);
            $query = "select * from $tbl where $implode_id = :id";
            $stat = $this->conn()->prepare($query);
            $stat->execute([':id' => $id]);
            if ($stat) {
                while($row = $stat->fetch(PDO::FETCH_ASSOC)){
                    $data [] = $row;
                }  
                    http_response_code(200);
                    $result_data = array("message" => $data);
                }
             else {
                http_response_code(400);
                $result_data = array("message" =>"error occured Please Contact Admin !");
            }
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }

        echo json_encode($result_data);
    }
     // dynamic fill
    public function fill($tbl,$fields)
    {
        try {
            $implode = implode(",",array_keys($fields));
            $result_data = array();
            $query = "select $implode from $tbl";
            $stat = $this->conn()->prepare($query);
            $stat->execute();
            if ($stat) {
                if($stat->rowCount()){
                    while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    http_response_code(200);
                    $result_data = array("message" => $data);
                }
                else {
                    http_response_code(400);
                    $result_data = array("message" => "Data Not Found");
                }
            } else {
                http_response_code(400);
                $result_data = array("message" =>"error occured Please Contact Admin !");
            }
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }
        echo json_encode($result_data);
    }
  

    //  // login function
    public function login($user_name,$password)
    {
        try {
            $query = "Exec usp_users_login  '$user_name','$password'";
            $stat = $this->conn()->query($query);
            $result_data = array();
            $stat->execute();
            if ($stat) {
                while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                    if(isset($row['message'])){
                        if($row['message']=='invalid'){
                            http_response_code(400);
                            $result_data = array("message" => "Username Or Password is incorrect!");
                        }
                    }else{
                        foreach($row as $key=>$value){
                            $_SESSION[$key]=$value;
                        }
                        $_SESSION['System']='Base';
                        // echo $_SESSION['user_name'];
                        if($_SESSION['user_status']=='disabled'){
                            http_response_code(400);
                            $result_data = array("message" => "blocked");
                            session_unset();
                            session_destroy();
                        }else{
                            $headers = array('alg'=>'HS256','typ'=>'JWT');
                            $payload = array('username'=>$_SESSION['user_name'], 'exp'=>(time() + 60));

                            $jwt =  $this->generate_jwt($headers, $payload);
                            http_response_code(200);
                            $result_data = array(
                            "status" => true,
                            'token' => $jwt,
                            "message" => "You Welcome",

                            );
                        }
                        
                    }
                }
            }
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }
        

        echo json_encode($result_data);
    }

     // Loop delete
    public function LoopDelete($idl,$tbl)
    { 
        try {
            $implode_id = implode(",",array_keys($idl));
            $user_id = implode(",",$idl);
            $result_data = array();
            $sql = "DELETE FROM $tbl WHERE $implode_id = :user_id";
            $res = $this->conn()->prepare($sql);
            $final =  $res->execute([':user_id' => $user_id]);
            // return $final;
            if ($final) {
                http_response_code(200);
                return 1;
            } else {
                http_response_code(400);
                return "error occured Please Contact Admin !";
            }
        } catch (PDOException $ex) {
            http_response_code(400);
            $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
            // $this->conn()->pdo->errorInfo()
        }
       
        echo json_encode(($result_data));
    }
// update image function
public function img_update($id,$name)
{
    try {
        /* Getting file name */
        $filename = "$id"."-". $name;
        /* Location */
        $location = "../uploads/".$filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        
        /* Valid Extensions */
        $valid_extensions = array("jpg", "jpeg", "png");
        /* Check file extension */
        if (!in_array(strtolower($imageFileType), $valid_extensions)) {
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo 0;
        } else {
            /* Upload file */
            $result_d = array();
            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                // deleting old user image
                $query = 'select img_profile from users where user_id=:id';
                $result = $this->conn()->prepare($query);
                $result->execute([':id'=>$id]);
                $data = $result->fetch(PDO::FETCH_ASSOC);
                $default_image = '../uploads/user.png';
                $file_p = '../uploads/'.$data["img_profile"];;
                if(file_exists($file_p) and $file_p != $default_image){
                    unlink($file_p);
                }
                
                $query = "update users set users.img_profile  = '$filename' where users.user_id='$id'";
                $result = $this->conn()->query($query);
                if ($result) {
                    http_response_code(200);
                    $result_d = array("message"=>"Image Has Been Save Sauccessfully");
                } else {
                    http_response_code(400);
                    $result_d = array("message"=>"error occured Please Contact Admin !");
                }
        
                //echo $location;
            } else {
                http_response_code(400);
                $result_d = array("message"=>"Image Has Not Been Uploaded Sauccessful");
            }
        }
    }catch (PDOException $ex) {
        http_response_code(400);
        $result_data = array("title"=>"error occured Please try again!","message" =>$ex->getMessage());
        // $this->conn()->pdo->errorInfo()
    }
    echo json_encode($result_d);
}
// remove image function
public function remove_img($img)
{
    /* Getting file name */
    $default_image = '../uploads/user.png';
    $file_p = '../uploads/' . $img;
    if (file_exists($file_p) and $file_p != $default_image and $img != "") {
        unlink($file_p);
        return 1;
    } else {
        return 0;
    }
}
// api encreption methods

function generate_jwt($headers, $payload, $secret = 'secret') {
	$headers_encoded = $this->base64url_encode(json_encode($headers));
	
	$payload_encoded = $this->base64url_encode(json_encode($payload));
	
	$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
	$signature_encoded = $this->base64url_encode($signature);
	
	$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
	return $jwt;
}

public function is_jwt_valid($jwt, $secret = 'secret') {
	// split the jwt
    try {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) < 0;

        // build a signature based on the header and payload using the secret
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = $this->base64url_encode($signature);

        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);
        
        if ($is_token_expired || !$is_signature_valid) {
            return FALSE;
        } else {
            return TRUE;
	}
    } catch (PDOException $ex) {
        return FALSE;
    }
	
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function get_authorization_header(){
	$headers = null;
	
	if (isset($_SERVER['Authorization'])) {
		$headers = trim($_SERVER["Authorization"]);
	} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
		$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	} else if (function_exists('apache_request_headers')) {
		$requestHeaders = apache_request_headers();
		// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
		$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
		//print_r($requestHeaders);
		if (isset($requestHeaders['Authorization'])) {
			$headers = trim($requestHeaders['Authorization']);
		}
	}
	
	return $headers;
}

public function get_bearer_token() {
    $headers = $this->get_authorization_header();
	
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

}
