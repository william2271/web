<?php
header("Access-Control-Allow-Origin: *");

if($_POST)
{
    $to_Email       = "mail@example.com"; 
    $subject        = 'Email from your site';


 
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

     
        $output = json_encode(
        array(
            'type'=>'error',
            'text' => 'Request must come from Ajax'
        ));

        die($output);
    }

  
    if(!isset($_POST["userName"]) || !isset($_POST["userEmail"]) ||  !isset($_POST["userComment"]))
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
        die($output);
    }

   
    $user_Name        = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
    $user_Email       = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
    $user_Comment     = filter_var($_POST["userComment"], FILTER_SANITIZE_STRING);

  
    $headers = 'From: '.$user_Email.'' . "\r\n" .
    'Reply-To: '.$user_Email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

        
    $sentMail = @mail($to_Email, $subject, $user_Comment .'  -'.$user_Name, $headers);

    if(!$sentMail)
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Thank you for your email'));
        die($output);
    }
}
?>