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
		<input type="text" name="nome">
		<input type="text" name="e-mail">
		<input type="text" name="telefone">
		<input type="text" name="mensagem">
		<div class="g-recaptcha" data-sitekey="SUA_KEY"></div>
		<input type="submit" value="Enviar">
	</form>	
</body>
</html>