<!DOCTYPE html>
<html>
<head>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Google Recaptcha</title>		
</head>
<body>
		<form action="php/contact.php" method="POST">
        		<input type="text" name="nome" required="Gostariamos de saber o seu nome" placeholder="Informe o seu nome">
                <input type="text" name="e-mail" required="O seu e-mail é muito importante" placeholder="Informe o seu e-mail">
                <input type="text" name="telefone" required="O seu telefone é muito importante" placeholder="Informe o seu telefone">
                <textarea name="mensagem" class="message" required="Informe a sua mensagem" placeholder="Informe a sua mensagem"></textarea>
				<div class="g-recaptcha" data-sitekey="SUA_KEY"></div>
                <input type="submit" name="btnEnviar" class="btn btn-primary" value="Enviar">                		             
        </form> 
</body>
</html>