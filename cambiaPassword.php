<!DOCTYPE HTML>
<html>
	<head>
		<title>Cambia password</title>
		<link rel="stylesheet" href="css/style.css" />
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.png" />
		<script>
			function cambiaPassword()
			{
				document.getElementById('resultLogin').style.height="0px";
				document.getElementById('resultLogin').innerHTML="";
				
				var username=document.getElementById("username").value;
				var passwordVecchia=document.getElementById("vecchiaPassword").value;
				var nuovaPassword1=document.getElementById("password").value;
				var nuovaPassword2=document.getElementById("confermaPassword").value;
				if(nuovaPassword1=="" || nuovaPassword2=="")
				{
					document.getElementById('resultLogin').style.height="60px";
					document.getElementById('resultLogin').innerHTML= "Compila tutti i campi";
				}
				else
				{
					if(nuovaPassword1!=nuovaPassword2)
					{
						document.getElementById('resultLogin').style.height="60px";
						document.getElementById('resultLogin').innerHTML = "Le password inserite non corrispondono";
					}
					else
					{
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								//console.log(this.responseText);
								if(this.responseText=="ok")
								{
									location.href="login.php";
								}
								else
								{
									document.getElementById('resultLogin').style.height="60px";
									document.getElementById('resultLogin').innerHTML=this.responseText;
								}
							}
						};
						xmlhttp.open("POST", "checkCambiaPassword.php?username=" + username + "&passwordVecchia=" + passwordVecchia + "&nuovaPassword1=" + nuovaPassword1 + "&nuovaPassword2=" + nuovaPassword2, true);
						xmlhttp.timeout = 25000; // Set timeout to 4 seconds (4000 milliseconds)
						xmlhttp.ontimeout = function () 
						{ 
							document.getElementById('resultLogin').innerHTML="Impossibile contattare il server";
						}
						xmlhttp.send();
					}
				}
			}
		</script>
	</head>
	<body>
		<div id="container">
			<div id="middle">
				<div id="inner">
					<div id="loginBackgroundImage"><div id="loginText">Cambia password</div></div>
					<div class="inputContainer" style="margin-top:15px">
						<input type="text" id="username" placeholder="Username" />
					</div>
					<div class="inputContainer">
						<input type="password" id="vecchiaPassword" placeholder="Vecchia password" />
					</div>
					<div class="inputContainer">
						<input type="password" id="password" placeholder="Nuova password" />
					</div>
					<div class="inputContainer">
						<input type="password" id="confermaPassword" placeholder="Conferma password" />
					</div>
					<div class="inputContainer" id="resultLogin" style="height:0px;"></div>
					<div id="containerAccediApplicazioni" style="margin-top:30px">
						<div id="titleAccediApplicazioni"></div>
						<button class="btnApplicazione" id="btnCambiaPassword" onclick="cambiaPassword()"><span>Cambia password</span></button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>