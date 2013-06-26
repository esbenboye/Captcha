<!DOCTYPE html>
<html>
  <head>
    <title>Simple Captcha demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
	<?php
		session_start();
		include("setup.php");
	?>
	<form action="" method="post" name="userpass">
		<img src="cap.php" style="width:65px;height:25px;"><br>
		<input type="text" name="captcha">
		<input type="submit">
	</form>
	
	<!-- For demonstration only. -->
	<?php
	if(isset($_POST["captcha"]))
	{
		if(hash($setup->hashfunction, $setup->salt.$_POST["captcha"]) == $_SESSION[$setup->sessionname])
		{
			echo "It's good";
		}
		else
		{
			echo "It's bad!";
		}
	
	}
	
	?>
  </body>
</html>