<?php
spl_autoload_register(function ($std) {
    require_once "../classess/" . $std . ".php";
});
require '../phpmailer/PHPMailerAutoload.php';
$action = $_POST['action'];

date_default_timezone_set('Africa/Mogadishu');
function resetpassword()
{
    extract($_POST);
    $result_data = array();
    $fields =  json_decode(base64_decode($token), true);
    $user_id = $fields['user_id'];

    $fech_date = strtotime($merber_id = $fields['exptime']);
    $cur_date = strtotime(date('Y-m-d h:i:s'));
    if ($fech_date > $cur_date) {
        $id = [
            "user_id" => "$user_id"
        ];
        $fields = [
            "token" => "",
        ];
        $object = new Base();
        $message = $object->get_column($id, $fields, "users");
        if (is_array($message)) {
            $db_token = 0;
            foreach ($message as $row) {
                $db_token = $row['token'];
            }
            if ($db_token == $token) {
                $fields = [
                    "user_id" => $user_id,
                    "password" => $pass
                ];
                $object = new Base();
                $object->dml("update_pass", $fields);
            } else {
                http_response_code(400);
                $result_data = array("message" => "Invalid Token");
                echo json_encode($result_data);
            }
        }
    } else {
        http_response_code(400);
        $result_data = array("message" => "Token Expired");
        echo json_encode($result_data);
    }
}




function requestforget()
{
    extract($_POST);

    $checkMail = 0;
    $user_id = 0;
    $id = [
        "email" => "$to",
    ];
    $fields = [
        "user_id" => "",
        "email" => ""

    ];
    $object = new Base();
    $message = $object->get_column($id, $fields, "users");
    if (is_array($message)) {
        foreach ($message as $row) {
            $user_id = $row['user_id'];
            $checkMail = $row['email'];
        }
        if ($checkMail == $to) {
            $fields = [
                'user_id' => $user_id,
                'email' => sha1($to),
                'exptime' => date('Y-m-d h:i:s', time() + (60 * 2)),
                'charecter' => "="
            ];


            $urltoken = base64_encode(json_encode($fields));             // Set email format to HTML
            $url = "http://" . $_SERVER['SERVER_NAME'] . "/view/auth-password-reset?token=$urltoken";
            $html = '<div>you have requested a password reset for your account 
at System Base . you can do this by clicking the link below.:<br>' . $url . '<br><br>
<strong>Please note: this link is valid for 2 Minutes.</strong></div>';
            $id = [
                "user_id" => $user_id
            ];
            $fields = [
                "token" => $urltoken
            ];
            $object = new Base();
            $result = $object->update($fields, $id, "users");
            // echo $url;
            if ($result == 1) {
                $mail = new PHPMailer;
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'basemyapp@gmail.com';                 // SMTP username
                $mail->Password = 'khvueotdaaadmwxo';                            // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                // $mail->SMTPDebug = 4; 
                $mail->setFrom('basemyapp@gmail.com', 'Reset Password');
                $mail->addAddress($to);     // Add a recipient
                // $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('basemyapp@gmail.com');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body    = $html;
                $mail->AltBody = 'wxaan tijaa binaynaa messgekaan';

                if ($mail->send()) {
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                    http_response_code(200);
                    $result_data = array("message" => "Link has been Sent to" . " " . $to);
                } else {
                    // echo 'Message has been sent';
                    http_response_code(400);
                    $result_data = array("message" => $mail->ErrorInfo);
                }
                echo json_encode($result_data);
            }
        }
    }

    // Enable verbose debug output

}



if (isset($action)) {
    $action();
} else {
    http_response_code(400);
    $result_data = array("message" => "you don't have authentication !");
    echo json_encode($result_data);
}
