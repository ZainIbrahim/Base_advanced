<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || !isset($_SESSION['System']) || $_SESSION['System'] != "Base") {
	header("Location: auth-signin");
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr" data-theme="light">


<!-- Mirrored from www.pixelwibes.com/template/my-task/html/dist/ui-elements/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Jan 2022 08:04:47 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- <title>:: My-Task:: Ui Index</title> -->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="http://fonts.gstatic.com/" crossorigin>
        <link rel="shortcut icon" href="../assets/images/resseler.png" type="png/jpg"/>
    <!-- Favicon-->
    <!-- project css file  -->
    <link rel="stylesheet" href="../assets/css/my-task.style.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/toastr/toastr.min.css" />
    <link rel="stylesheet" href="../assets/plugin/datatables//responsive.dataTables.min.css">
    <link rel="stylesheet" href="../assets/plugin/datatables/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="../assets/dropify/dropify.min.css" />
    <link rel="stylesheet" href="../assets/jquery-file-upload/jquery.uploadfile.min.css" />
    <link rel="stylesheet" href="../assets/jquery-tags-input/jquery.tagsinput.min.css" />
   

    <style>
        
        :hover.btn-info{
            color:white
        }
        .btn-info{
            color:white
        }
        :hover.btn-success{
            color:white
        }
        .btn-success{
            color:white
        }
        .btn-danger{
            color:white
        }
        :hover.btn-danger{
            color:white
        }
    </style>

</head>