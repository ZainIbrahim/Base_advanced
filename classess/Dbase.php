<?php
class Dbase{
    protected function conn(){
        try{
            // sql connection
            $servername = ".";
            $username = "sa";
            $password = "123";
            $database = "base";
            $port = "1433";
// 
        //     $dns = "mysql:host=localhost;dbname=std";
        //     $password = '';
        //     $user_name = 'root';
        //     $option = [];
        //     $connection = new PDO($dns,$user_name,$password,$option);
        $connection = new PDO("sqlsrv:server=$servername,$port;Database=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;

        }catch(PDOException $ex){
            echo $ex->getMessage();
        }


    }
}

?>