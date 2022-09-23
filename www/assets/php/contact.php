<?php

if(isset($_POST['message'])){

	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
    
	
	$to      = 'xxx_darkforces@mail.ru';
	$subject = 'Отправка сообщения с сайта ForceWeb';

	$headers = 'From: '. $email . "\r\n" .
    'Reply-To: '. $email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	$status = mail($to, $subject, $message, $headers);

	if($status == TRUE){	
		$res['sendstatus'] = 'done';
	
		//Edit your message here
		$res['message'] = 'Сообщение успешно отправлено';
    }
	else{
		$res['message'] = 'Ошибка отправки сообщения. пожалуйста напишите мне на xxx_darkforces@mail.ru';
	}
	
	
	echo json_encode($res);
}

?>