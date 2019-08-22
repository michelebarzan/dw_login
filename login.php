<!DOCTYPE HTML>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/style.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<script>
			function login(applicazione,server)
			{
				console.log(server);
				var username=document.getElementById("username").value;
				var password=document.getElementById("password").value;
				var ricordaPassword=document.getElementById("checkbox4").checked;
				applicazione=applicazione.toLowerCase();
				
				document.getElementById('resultLogin').style.height="0px";
				document.getElementById('resultLogin').innerHTML="";
				
				console.log(server);
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(this.responseText=="ok")
						{
							location.href="http://"+server+"/dw_"+applicazione+"/index.php";
						}
						else
						{
							document.getElementById('resultLogin').style.height="60px";
							document.getElementById('resultLogin').innerHTML=this.responseText;
						}
					}
				};
				xmlhttp.open("POST", "checkLogin.php?username=" + username +"&password="+password+"&ricordaPassword="+ricordaPassword+"&applicazione="+applicazione, true);
				xmlhttp.timeout = 25000; // Set timeout to 4 seconds (4000 milliseconds)
				xmlhttp.ontimeout = function () 
				{ 
					document.getElementById('resultLogin').innerHTML="Impossibile contattare il server";
				}
				xmlhttp.send();
			}
		</script>
	</head>
	<body>
		<div id="container">
			<div id="middle">
				<div id="inner">
					<div id="loginBackgroundImage"><div id="loginText">Login</div></div>
					<div class="inputContainer" style="margin-top:15px">
					<?php
						if(isset($_COOKIE['username']) && $_COOKIE['username']!="no")
						{
							?><input type="text" id="username" placeholder="Username" value="<?php echo $_COOKIE['username']; ?>" /><?php
						}
						else
						{
							?><input type="text" id="username" placeholder="Username" /><?php
						}
						?>
					</div>
					<div class="inputContainer">
						<?php
						if(isset($_COOKIE['password']) && $_COOKIE['password']!="no")
						{
							?><input type="password" id="password" placeholder="Password" value="<?php echo $_COOKIE['password']; ?>" /><?php
						}
						else
						{
							?><input type="password" id="password" placeholder="Password" /><?php
						}
						?>
					</div>
					<div class="inputContainer">
						<input type="checkbox" class="css-checkbox" id="checkbox4"  checked="checked"/>
						<label for="checkbox4" name="checkbox1_lbl" class="css-label lite-gray-check"><div style="margin-left:7px">Ricorda password</div></label>
					</div>
					<div class="inputContainer" id="resultLogin" style="height:0px;"></div>
					<?php $server=$_SERVER['SERVER_NAME'];?>
					<div id="containerAccediApplicazioni">
						<div id="titleAccediApplicazioni">Accedi ad una delle applicazioni</div>
						<button class="btnApplicazione btnApplicazioneLeft" id="btnGestione" onclick="login('programmazione','<?php echo $server; ?>')"><span>Programmazione</span></button>
						<button class="btnApplicazione btnApplicazioneRight" id="btnCantiere" onclick="login('cantiere','<?php echo $server; ?>')"><span>Cantiere</span></button>
						<button class="btnApplicazione btnApplicazioneLeft" id="btnProduzione" onclick="login('produzione','<?php echo $server; ?>')"><span>Produzione</span></button>
						<button class="btnApplicazione btnApplicazioneRight" id="btnAmministrazione" onclick="login('amministrazione','<?php echo $server; ?>')"><span>Amministrazione</span></button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>