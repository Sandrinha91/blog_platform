<?php

namespace App\Models;

use App\Core\Database\Connection;
use PDO;
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class ForgotPassword
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //set expire time for recover pass
    public function setExpire()
    {
        $expire = date('U') + 600;
        return $expire;
    }

    //set expire time for recover pass
    public function sentEmail($email, $subject, $message)
    {
        $mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // SMTP::DEBUG_OFF = off (for production use)
        // SMTP::DEBUG_CLIENT = client messages
        // SMTP::DEBUG_SERVER = client and server messages
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //$mail->Host = '178.222.61.186';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption mechanism to use - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$mail->SMTPSecure = 'ssl';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'srbijafantasy@gmail.com';

        //Password to use for SMTP authentication
        $mail->Password = 'sahara1990';

        //Set who the message is to be sent from
        $mail->setFrom('no-replay@vukmasaza.com', 'no-replay@vukmasaza.com');

        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($email);

        //Set the subject line
        $mail->Subject = $subject;

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

        $mail->Body = $message;
        //Replace the plain text body with one created manually
        $mail->AltBody = $message;
        $mail->IsHTML(true);
        
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
        } else {
            //var_dump('Message sent');
            //echo 'Message sent!';
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }

        // $to = $email;

        // $subject = "Reset your password for vuk_masaza";

        // $message = "<p>We recived a password reset request. The link to reset your password is bellow. 
        //                 If you did not make this request, you can ignore this email.</p>";
        // $message .= "<p>Here is your password reset link: <br>";
        // $message .= "<a href='$url'>$url</a></p>";

        // $headers = "From: blog <vuk@gmail.com >\r\n";
        // $headers .= "Reply-To: vuk@gmail.com \r\n";
        // $headers .= "Content-type: text/html \r\n";
        
        // mail($to, $subject, $message, $headers);
    }

    //delete existing token for passed email
    public function removeToken($email)
    {
        $sql = "DELETE FROM pwd_reset WHERE pwd_reset_email = :pwd_reset_email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':pwd_reset_email' => $email]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //store token in db
    public function storeToken($email, $selector, $token, $expire)
    {
        $sql = "INSERT INTO pwd_reset (pwd_reset_email, pwd_reset_selector, pwd_reset_token, pwd_reset_expires)
                    VALUES (:pwd_reset_email, :pwd_reset_selector, :pwd_reset_token, :pwd_reset_expires);";
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':pwd_reset_email' => $email,
                                ':pwd_reset_selector' => $selector,
                                ':pwd_reset_token' => $token,
                                ':pwd_reset_expires' => $expire,
                                ]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select selector == $selector
    public function selectSelector($selector, $curentTime)
    {
        $sql = "SELECT * FROM pwd_reset WHERE pwd_reset_selector = :pwd_reset_selector AND pwd_reset_expires >= :pwd_reset_expires";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':pwd_reset_selector' => $selector, ':pwd_reset_expires' => $curentTime]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //select user from admin table where email = $tokenemail
    public function selectUser($tokenEmail)
    {
        $sql = "SELECT * FROM admin WHERE email = :email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':email' => $tokenEmail]);
            $result = $statement->fetchAll(PDO::FETCH_CLASS);
            return $result;
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }

    //set new admin pass
    public function updatePass( $password, $email )
    {
        $sql = "UPDATE admin SET password = :password WHERE email = :email";
        
        try
        {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':password' => $password, ':email' => $email]);
        }
        catch(Exception $e)
        {
            die('Whoops, something went wrong' . $e->getMessage());
        }
    }


}

?>