

<?php


/*
THIS FILE USES PHPMAILER INSTEAD OF THE PHP MAIL() FUNCTION
AND ALSO SMTP TO SEND THE EMAILS
*/

require 'PHPMailer-master/PHPMailerAutoload.php';

/*
*  CONFIGURE EVERYTHING HERE
*/

// an email address that will be in the From field of the email.
//Direccion que envia el correo
$fromEmail = 'coffeelasterrazasladorada14@gmail.com';
$fromName = 'Coffee Las Terrazas';

// an email address that will receive the email with the output of the form
//Direccion que recibe el Correo
$sendToEmail = 'felipearias17@hotmail.com';
$sendToName = 'Coffee Las Terrazas';

// subject of the email
$subject = 'Mensaje enviado desde la Web Coffee Las Terrazas';

// smtp credentials and server
//Direccion que envia el correo y sus credenciales
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'coffeelasterrazasladorada14@gmail.com';
$smtpPassword = 'cachascoffee14';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Nombre', 'email' => 'Email', 'number' => 'Telefono', 'mess' => 'Mensaje');


// message that will be displayed when everything is OK :)
$okMessage = 'Tu Mensaje se ha enviado, Gracias, Pronto nos Comunicaremos Con Usted';

// If something goes wrong, we will display this message.
$errorMessage = 'Lo sentimos, ha habido un error, intenta mas tarde';

/*
*  LET'S DO THE SENDING
*/

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(0);

try {
    if (count($_POST) == 0) {
        throw new \Exception('Form is empty');
    }
    
    $emailTextHtml = "<h3>Mensaje del Sitio Web Coffee Las Terrazas</h3><hr>";
    $emailTextHtml .= "<table>";
    
    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        if (isset($fields[$key])) {
            $emailTextHtml .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table><hr>";
        
    
    $mail = new PHPMailer;
    
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($sendToEmail, $sendToName); // you can add more addresses by simply adding another line with $mail->addAddress();
    $mail->addReplyTo($from);
    
    $mail->isHTML(true);
    
    $mail->Subject = $subject;
    $mail->Body    = $emailTextHtml;
    $mail->msgHTML($emailTextHtml); // this will also create a plain-text version of the HTML email, very handy
    
    
    $mail->isSMTP();
    
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    
    //Set the hostname of the mail server
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    $mail->Host = $smtpHost;
    
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'starttls';
    
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $smtpUsername;
    
    //Password to use for SMTP authentication
    $mail->Password = $smtpPassword;
    
    $mail->send();
    
    echo'<script type="text/javascript">
     alert("Tu Mensaje ha sido recibido. Pronto Nos Comunicaremos Con Usted");
    window.location.href="index.html";
    </script>';

  } 
  
  catch (Exception $e){
    $alert = '<div class="alert-error">
                <span>'.$e->getMessage().'</span>
              </div>';
  } 

    
   // if (!$mail->send()) {
   //     throw new \Exception('No se puede enviar el mensaje.' . $mail->ErrorInfo);
    
    
 //   $responseArray = array('type' => 'success', 'message' => $okMessage);
//} catch (\Exception $e) {
    // $responseArray = array('type' => 'danger', 'message' => $errorMessage);
   // $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
//}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}

