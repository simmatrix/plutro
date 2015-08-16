<?php defined('BASEPATH') or die('Unauthorized Access');

class Mailer_Helper
{
	public function sendMailBySMTP( $subject = '', $body = '', $to = '', $toName = '', $from = 'hello@imsdev.com', $fromName = 'IMS', $attachmentPaths = array(), $cc = array() )
	{
		$mail = new PHPMailer;

		// $mail->SMTPDebug  = 3;                    			// Enables SMTP debug information (for testing)
		$mail->IsSMTP();										// Set mailer to use SMTP
		$mail->Host 		= 'smtp.mandrillapp.com';			// Specify main and backup server
		$mail->SMTPAuth 	= true;								// Enable SMTP authentication
		$mail->Username 	= IMS_SMTP_USERNAME;				// SMTP username
		$mail->Password 	= IMS_SMTP_PASSWORD;				// SMTP password
		$mail->SMTPSecure 	= 'tls';							// Enable encryption, 'ssl' also accepted
		$mail->Port 		= 587;								// Set the SMTP port

		$mail->From 		= $from;
		$mail->FromName 	= $fromName;
		$mail->addAddress( $to, $toName); 						// Add a recipient
		// $mail->addAddress('ellen@example.com'); 				// Name is optional
		// $mail->addReplyTo('info@example.com', 'Information');
		if( !empty($cc) )
		{
			foreach( $cc as $email )
			{
				$mail->addCC( $email );
			}
		}
		// $mail->addBCC('bcc@example.com');
		// $mail->addAttachment('/var/tmp/file.tar.gz'); 		// Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 	// Optional name

		if( !empty($attachmentPaths) )
		{
			foreach( $attachmentPaths as $path )
			{
				$mail->addAttachment( $path );
			}
		}
		$mail->isHTML(true);									// Set email format to HTML
		$mail->Subject 		= $subject;
		$mail->Body 		= $body;
		$mail->AltBody 		= strip_tags( $body );

		if(!$mail->Send())
		{
			return false;
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		return true;
	}
}
