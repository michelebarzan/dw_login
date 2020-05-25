<?php
	include "connessione.php";
	
	if($conn)
	{
		$username= $_REQUEST ['username'];
		$P=$_REQUEST ['password'];
		$password=sha1($P);
		$applicazione= $_REQUEST ['applicazione'];
		
		$query="SELECT * FROM utenti";
		$result=sqlsrv_query($conn,$query);
		if($result==FALSE)
		{
			$query=str_replace("'","*APICE*",$query);
			$testoErrore=print_r(sqlsrv_errors(),TRUE);
			$testoErrore=str_replace("'","*APICE*",$testoErrore);
			$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
			$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$query','".$testoErrore."','".$username."(login)')";
			$resultErrori=sqlsrv_query($conn,$queryErrori);
			$query=str_replace("*APICE*","'",$query);
			die("Errore nel login. Riprova piu tardi");
		}
		else
		{
			while($row=sqlsrv_fetch_array($result)) 
			{	
				if($row['username']==$username)
				{
					if($row['password']==$password)
					{
						if($_REQUEST ['ricordaPassword']=='true')
						{
							$hour = time() + 3600 * 24 * 30;
							setcookie('username', $username, $hour);
							setcookie('password', $P, $hour);
						}
						else
						{
							$hour = time() + 3600 * 24 * 30;
							setcookie('username',"no", $hour);
							setcookie('password', "no", $hour);
						}
						if(checkPermessi($conn,$row['id_utente'],$applicazione)=='true')
						{
							session_start();
							$_SESSION['Username']=$username;
							$_SESSION['Password']=$password;
							$_SESSION['id_utente']=$row['id_utente'];
							echo "ok";
							$errore="No";
							break;
						}
						else
							die("Non disponi dei permessi necessari per accedere");
					}
					else
					{
						$errore="Si";
					}
				}
				else
				{
					$errore="Si";
				}
			}
			if($errore=="Si")
				echo "Credenziali errate";
		}
	}
	else
	{
		echo "Impossibile connettersi al server";
		//die(print_r(sqlsrv_errors(),TRUE));
	}
	
	function checkPermessi($conn,$id_utente,$applicazione)
	{
		$q="SELECT permesso FROM permessi_pagine,elenco_pagine WHERE permessi_pagine.pagina=elenco_pagine.id_pagina AND permessi_pagine.utente=$id_utente AND elenco_pagine.applicazione='$applicazione' AND elenco_pagine.pagina='index.php'";
		$r=sqlsrv_query($conn,$q);
		if($r==FALSE)
		{
			$q=str_replace("'","*APICE*",$q);
			$testoErrore=print_r(sqlsrv_errors(),TRUE);
			$testoErrore=str_replace("'","*APICE*",$testoErrore);
			$testoErrore=str_replace('"','*DOPPIOAPICE*',$testoErrore);
			$queryErrori="INSERT INTO erroriWeb (data,query,testo,utente) VALUES ('".date('d/m/Y H:i:s')."','$q','".$testoErrore."','".$username."(login)')";
			$resultErrori=sqlsrv_query($conn,$queryErrori);
			$q=str_replace("*APICE*","'",$q);
			die("Errore nel login. Riprova piu tardi");
		}
		else
		{
			while($row=sqlsrv_fetch_array($r))
			{
				return $row['permesso'];
			}
		}
	}
?>