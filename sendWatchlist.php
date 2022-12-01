<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['whatever'])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thekomzonlineyard@gmail.com'; //gmail
    $mail->Password = 'zcvopeklnniwblfn'; //gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('thekomzonlineyard@gmail.com'); //gmail

    $mail->addAddress('kiriakicharalambous@gmail.com');

    $mail->isHTML(true);

    $mail->Subject ='hey';
    $mail->Body = 'you';

    $mail->send();

    echo

    "        <script>
        alert('Sent Successfully');
        document.location.href = 'browse.php';
        </script>
        ";


}

?>