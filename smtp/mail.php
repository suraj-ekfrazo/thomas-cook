<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("./src/class.phpmailer.php");
require("./src/PHPMailerAutoload.php");
require("./src/SMTP.php");


		$email="nishant@dataseedtech.com";
		$sub='Test';
		$to="nishant@dataseedtech.com";
		$full_name='Nishant';
		$message = "
<html>
<head>
<title>D&D Pharmaceuticals</title>
</head>
<body>
";

$message.="<table width='100%' height='10%'>

				<tr>

					<td align='center' width='40%'><img src='http://www.dndpharmaceuticals.com/d&d_logo.png' width='400px' height='100px'/></td>

					<td align='right' width='60%' ><h4>".date('d-m-Y')." Call Report</h4></td>

				</tr>

			</table><hr/>";


$message.="</body></html>";
		
		//************Send mail process*************//	
		send_mail($email,$sub,$message,$to,$full_name);

function send_mail($email,$subject,$message,$to,$full_name)
{
	//************Send mail process*************//	
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->IsHTML(true);
	/* Sent mail from */
	$mail->Username = "nishantmlad@gmail.com";
	$mail->Password = "lukcpurstzcqelti";
	$mail->From = "nishantmlad@gmail.com";
	$mail->FromName = "Nishant";
	$mail->Subject = "Test";
	$mail->Body = $message;
	/* Sent mail to */
	$mail->AddAddress("nishant@dataseedtech.com");
	$mail->addReplyTo("nishant@dataseedtech.com");
	/*$file_tmp  = $_FILES['recipient-resume']['tmp_name'];
	$file_name = $_FILES['recipient-resume']['name'];
	$mail->AddAttachment($file_tmp, $file_name);*/
	 if(!$mail->Send()) {
		echo  $mail->ErrorInfo;
	 } else {
	 	
		echo "Send mail successfully";
	 }
}

?>
