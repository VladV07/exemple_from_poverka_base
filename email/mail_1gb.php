<?php
define('SERV_NAME', 'https://192.168.111.206');
// define('SERV_NAME', 'http://localhost');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
require_once '../conn.php';


 
// Для более ранних версий PHPMailer
// require_once '../PHPMailer/PHPMailerAutoload.php';

// http://localhost/email/mail_1gb.php?id_pribor=2&send_mail=vlad-v-07@mail.ru&pass=####

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$pass = $_GET['pass'];
	// echo $pass;
	if ($pass != "#####")
		die("Ошибка авторизации");
	$send_mail = $_GET['send_mail'];

	$res_black_list = mysqli_query($conn, "SELECT * FROM black_list_email WHERE email = '".$send_mail."'");
	if (mysqli_num_rows($res_black_list) > 0)
		die("Данная почта отписана от рассылки!");

	$id_pribor = $_GET['id_pribor'];
	$id_pribor_base64 = base64_encode($id_pribor);
	$row_pribor = mysqli_fetch_array(mysqli_query($conn, "SELECT pr.id, pr.nb_pribor, tp.type, pr.date, pr.reg_number FROM pribor2 pr INNER JOIN type_pribor tp WHERE pr.type_pribor_id = tp.id AND pr.id =".$id_pribor));
	$token = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM token_pribor WHERE id_pribor = ".$id_pribor))['token'];

	$image_url = SERV_NAME.'/api/get-qr-code.php?text=https://info.ximko.ru/info?id='.$id_pribor_base64.'%26token='.$token.'&level=Q&size=3px';
	$arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	); 
	$image = file_get_contents($image_url, false, stream_context_create($arrContextOptions));
	$file_name = 'qr'.time().'.png';
	file_put_contents($file_name, $image);


	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';

	 
	// Настройки SMTP
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPDebug = 0;
	 
	$mail->Host = '###';
	$mail->Port = 100;
	$mail->Username = '###';
	$mail->Password = '###';
	 
	// От кого
	$mail->setFrom('###@###.ru', 'ХИМКО');		
	 
	// Кому
	$mail->addAddress($send_mail);
	 
	// Тема письма
	$mail->Subject = $row_pribor['type'].' №'.$row_pribor['nb_pribor'];
	// Тело письма
	// $body = '<p><img src="cid:testImage"></p><p><strong>Привет! Тест отправки письма </strong></p>';

	$body = '
	<table class="nl-container_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#c5c4cf">
	<tbody><tr><td><table class="row_mr_css_attr row-1_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
	<tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:640px;margin:0 auto" width="640">
	<tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
	<div class="spacer_block_mr_css_attr block-1_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"> </div></td></tr></tbody></table></td></tr></tbody></table>
	<table class="row_mr_css_attr row-2_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
	<tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:640px;margin:0 auto" width="640">
	<tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
	<table class="image_block_mr_css_attr block-1_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
	<tbody><tr><td class="pad_mr_css_attr" style="padding-bottom:10px;padding-top:10px;width:100%;padding-right:0;padding-left:0"><div class="alignment_mr_css_attr" align="center" style="line-height:10px">
	<img src="cid:logo" style="display:block;height:auto;border:0;max-width:255px;width:100%" width="255"></div></td></tr></tbody></table><div class="spacer_block_mr_css_attr block-2_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"> </div></td></tr></tbody></table></td></tr></tbody></table><table class="row_mr_css_attr row-3_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:640px;margin:0 auto" width="640"><tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="text_block_mr_css_attr block-1_mr_css_attr" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="word-break:break-word"><tbody><tr><td class="pad_mr_css_attr"><div style="font-family:Arial, Helvetica, sans-serif;"><div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;color:#555;line-height:1.2" class="MsoNormal_mr_css_attr"><p style="margin:0;font-size:14px;text-align:center;" class="MsoNormal_mr_css_attr"><span style="font-size:42px;">
	<strong>Уведомление</strong></span></p></div></div></td></tr></tbody></table>
	<table class="text_block_mr_css_attr block-2_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word"><tbody><tr><td class="pad_mr_css_attr" style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px"><div style="font-family:Arial, Helvetica, sans-serif;"><div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;color:#555;line-height:1.2" class="MsoNormal_mr_css_attr"><p style="margin:0;text-align:center;" aria-level="2" class="MsoNormal_mr_css_attr">
	<span style="font-size:16px;">Ваш прибор '.$row_pribor['type'].' №'.$row_pribor['nb_pribor'].' получен и находится в работе. Посмотреть актуальные данные по прибору возможно на нашем сервисе перейдя по ссылке или qr-коду.</span></p></div></div></td></tr></tbody></table><div class="spacer_block_mr_css_attr block-3_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"></div></td></tr></tbody></table></td></tr></tbody></table><table class="row_mr_css_attr row-4_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td>
	<table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;background-position:center top;background-repeat:no-repeat;width:640px;margin:0 auto" width="640"><tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><table class="image_block_mr_css_attr block-1_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td class="pad_mr_css_attr" style="width:100%"><div class="alignment_mr_css_attr" align="center" style="line-height:10px">
	<img src="cid:qr" style="display:block;height:auto;border:0;max-width:210px;width:100%" width="210"></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table class="row_mr_css_attr row-5_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;width:640px;margin:0 auto" width="640"><tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><div class="spacer_block_mr_css_attr block-1_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"> </div><table class="heading_block_mr_css_attr block-2_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td class="pad_mr_css_attr" style="text-align:center;width:100%"><h1 style="margin:0;color:#555;direction:ltr;font-family:Arial, Helvetica, sans-serif;font-size:23px;font-weight:700;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0"><span class="tinyMce-placeholder_mr_css_attr">Ссылка на данные прибора</span></h1></td></tr></tbody></table>
	<table class="text_block_mr_css_attr block-3_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word"><tbody><tr><td class="pad_mr_css_attr" style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:10px"><div style="font-family:Arial, Helvetica, sans-serif;"><div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;color:#9393a0;line-height:1.2" class="MsoNormal_mr_css_attr"><p style="margin:0;font-size:14px;text-align:center;" class="MsoNormal_mr_css_attr">
	<a href="https://info.ximko.ru/info?id='.$id_pribor_base64.'&token='.$token.'" target="_blank" style="text-decoration: underline;color: #0068A5;" rel=" noopener noreferrer">https://info.ximko.ru/info?id='.$id_pribor_base64.'&token='.$token.'</a></p></div></div></td></tr></tbody></table><div class="spacer_block_mr_css_attr block-4_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"></div></td></tr></tbody></table></td></tr></tbody></table>
	<table class="row_mr_css_attr row-6_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff;color:#000;border-radius:0;width:640px;margin:0 auto" width="640"><tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
	<table class="social_block_mr_css_attr block-1_mr_css_attr" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation"><tbody><tr><td class="pad_mr_css_attr"><div class="alignment_mr_css_attr" align="center"><table class="social-table_mr_css_attr" width="72px" border="0" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block"><tbody><tr><td style="padding:0 2px 0 2px">
	<a href="https://ximko.ru/" target="_blank" rel=" noopener noreferrer"><img src="cid:reff" width="32" height="32" alt="Web Site" title="Web Site" style="display:block;height:auto;border:0"></a></td><td style="padding:0 2px 0 2px">
	<a href="//e.mail.ru/compose/?mailto=mailto%3apetrik@ximko.ru" target="_blank" rel=" noopener noreferrer"><img src="cid:mail" width="32" height="32" alt="E-Mail" title="E-Mail" style="display:block;height:auto;border:0"></a>
	</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table class="row_mr_css_attr row-7_mr_css_attr" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td><table class="row-content_mr_css_attr stack_mr_css_attr" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;width:640px;margin:0 auto" width="640"><tbody><tr><td class="column_mr_css_attr column-1_mr_css_attr" width="100%" style="font-weight:400;text-align:left;padding-bottom:5px;padding-top:5px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0"><div class="spacer_block_mr_css_attr block-1_mr_css_attr" style="height:20px;line-height:20px;font-size:1px"> </div></td></tr></tbody></table></td></tr></tbody></table></td></tr>
	<table class="text_block_mr_css_attr block-2_mr_css_attr" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="word-break:break-word"><tbody><tr><td class="pad_mr_css_attr" style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px"><div style="font-family:Arial, Helvetica, sans-serif;"><div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;color:#555;line-height:1.2" class="MsoNormal_mr_css_attr"><p style="margin:0;text-align:center;" aria-level="2" class="MsoNormal_mr_css_attr">
	<span style="font-size:16px;">Если больше не хотите получать уведомления перейдите по <a href="https://info.ximko.ru/mail/add_black_list.php?email='.$send_mail.'&id='.$id_pribor.'&token='.$token.'" target="_blank" rel=" noopener noreferrer">ссылке</a></span></p></div></div></td></tr></tbody></table>
	';

	$mail->msgHTML($body);


	$mail->AddEmbeddedImage('../logo.png','logo');
	$mail->AddEmbeddedImage('mail.png','mail');
	$mail->AddEmbeddedImage('ref.png','reff');
	$mail->AddEmbeddedImage($file_name,'qr');
	 
	 
	if ($mail->send()) {
		echo 'Письмо отправлено!';
	  } else {
		echo 'Ошибка: ' . $mail->ErrorInfo;
	  }

	unlink($file_name);

}

?>