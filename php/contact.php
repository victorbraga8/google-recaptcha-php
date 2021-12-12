<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php-mailer/src/PHPMailer.php';
require 'php-mailer/src/SMTP.php';
require 'php-mailer/src/Exception.php';


$captcha = $_POST['g-recaptcha-response'];

if(!$captcha){	
?>
	<script type="text/javascript">	
		nomeDg = "<?=$_POST['nome'].', '?>";							
		alert(`Olá ${nomeDg}, preencha o validador.`);		
		history.back();
	</script>
<?php	
	
}else{
	$secretKey = "SUA_KEY";
	$ip = $_SERVER['REMOTE_ADDR'];
	$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);

    if($responseKeys["success"]){

		$subject = ("Contato via seu Site: ".$_POST['nome']);

		$message = '';

		foreach($_POST as $label => $value) {
			$label = ucwords($label);

			if($label == "G-recaptcha-response" || $label == "Qt_hiddenRecaptcha" || $label == "Ct_hiddenRecaptcha"){
				$label = "";
				$value = "";
			}	

			$message .= $label."  " . htmlspecialchars($value, ENT_QUOTES) . "<br>\n";
		}

		$mail = new PHPMailer(true);

		try {

			// Mude para 2 se quiser Debugar
			$mail->SMTPDebug = 0;  

			$mail->IsSMTP();                                
			$mail->Host = 'smtp.seudominio.com ou .com.br';				
			$mail->SMTPAuth = true;                        
			$mail->Username = 'seu@email.com';  
			$mail->Password = 'suaSenha';
			$mail->SMTPSecure = 'tls'; 
			$mail->Port = 587; 
			
			$mail->AddAddress('primeiroDestinatario@seusite.com','Primeiro Destinatário');
			$mail->AddAddress('segundoDestinatario@seusite.com','Segundo Destinatário');
			$mail->AddCC('seu@email.com','Contato do Seu Site');

			$fromName = ( isset($_POST['nome']) ) ? $_POST['nome'] : 'Website User';
			$mail->setFrom('seu@email.com', $_POST['nome']);
			$mail->addReplyTo($_POST['e-mail'], $_POST['nome']);

			$mail->IsHTML(true);  

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			$mail->Send();
			$arrResult = array ('response'=>'success');

		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (\Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

		if($arrResult['response'] == "success"){
?>
			<script type="text/javascript">
				nomeDg = "<?=$_POST['nome'].', '?>";							
				alert(`Olá ${nomeDg}, sua mensagem foi enviada com sucesso, retornaremos em breve.`);
				window.location.replace('https://sua.url');
			</script>
<?php			
		}else{
?>
			<script type="text/javascript">
				nomeDg = "<?=$_POST['nome'].', '?>";							
				alert(`Olá ${nomeDg}, estamos com problemas para receber sua mensagem, por favor tente novamente mais tarde.`);
				window.location.replace('https://sua.url');
			</script>
<?php			
		}
		// if ($debug == 2) {						
		// 	echo json_encode($arrResult);
		// }
	}else{
		echo "Mensagem não aprovada.";
		header("Location: https://www.google.com");
		exit;
	}
}