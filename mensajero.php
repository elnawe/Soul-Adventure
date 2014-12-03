<?PHP
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribución de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para más información: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
include('lib.php');
include('cookies.php');
$link = opendb();
$userrow = checkcookies();
if ($userrow == false) { 
    if (isset($_GET["do"])) {
        if ($_GET["do"] == "verificar") { header("Location: usuarios.php?do=verificar"); die(); }
    }
    header("Location: entrar.php?do=entrar"); die(); 
}
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

// Juego Cerrado.
if ($controlrow["gameopen"] == 0) { display("El juego se encuentra en mantenimiento.","Juego Cerrado"); die(); }
// Forzar al usuario a verificarse.
if ($controlrow["verifyemail"] == 1 && $userrow["verify"] != 1) { header("Location: usuarios.php?do=verificar"); die(); }
// Bloquear usuario si está baneado.
if ($userrow["autorizacion"] == 2) { die("Tu cuenta ha sido bloqueada."); }

//Comprobar si el jugador esta en la ciudad, si no esta no deja ver el clan
 $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("<p><div class='contenido2'>Solo se puede acceder al mensajero desde la ciudad. Puedes volver a <a href=\"index.php\">Explorar</a>.</div>", "Error"); }
    $townrow = mysql_fetch_array($townquery);
	
	//Menu Mensajero

if (isset($_GET["do"])) {
    $do = explode(":",$_GET["do"]);
	if ($do[0] == "mensaje") { inbox(); }
    elseif ($do[0] == "responder") { reply($do[1]); }
    elseif ($do[0] == "leer") { read_mail($do[1]); }
    elseif ($do[0] == "nuevo") { write_mail(); }
    elseif ($do[0] == "masivo") { mass_mail(); }
    elseif ($do[0] == "borrar") { delete_mail($do[1]); }

} else { inbox(); }



function inbox() {
    global $userrow, $controlrow;
    $query = doquery("SELECT * FROM {{table}} WHERE destinatario='".$userrow['id']."' ORDER BY id DESC LIMIT 14", "mail");
	$total = mysql_num_rows($query);

    $page = "<form method=\"POST\" action=\"mensajero.php?do=borrar\">
	        <div class='contenido2'><table width=\"100%\"><tr><td style=\"padding:0px; background-color:black;\">
				<table width='580px' style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
					<tr>
						<th colspan=\"4\" style=\"background-color:#804000;\">
							<center>Bandeja Entrada $total/14</center>
						</th>
					</tr>
					<tr>
						<th width=\"40%\" style=\"background-color:#804000;\">
							Titulo:
						</th>
						<th width=\"20%\"style=\"background-color:#804000;\">
							Remitente:
						</th>
						<th width=\"30%\" style=\"background-color:#804000;\">
							Fecha:
						</th>
						<th style=\"background-color:#804000;\">
							Borrar
						</th>
					</tr>\n";
    	
    if (mysql_num_rows($query) == 0) 
		{ 
        	$page .= "<tr>
					  	<td style=\"background-color:#9D4F00;\" colspan=\"4\">
					  		<b>No tienes ningun mensaje</b>
					  	</td>
					  </tr>\n";
    	} 
	
	else 
		{ 
        	while ($row = mysql_fetch_array($query)) 
				{
            		$query2 = doquery("SELECT * FROM {{table}} WHERE id='$row[remitente]'", "usuarios");
            		$author = mysql_fetch_array($query2);
					
					//Marcamos con otro color los mensajes no leidos
					
       			 	if($row["estado"] == "leyendo")
						{
							$page .= "<tr>
									  	<td style=\"background-color:#9D4F00;\">
											<a href=\"mensajero.php?do=leer:".$row["id"]."\">".$row["title"]." <img border=0 src=\"estilo/imagenes/default/mensaje.jpg\"></a>
										</td>
										<td style=\"background-color:#9D4F00;\">
											<a href=\"index.php?do=enlinea:".$author["id"]."\">
											".$author["charname"]." </a>
										</td>
										<td style=\"background-color:#9D4F00;\">
											".$row["date"]."
										</td>
										<td style=\"background-color:#9D4F00;\">
										<center><input type=\"checkbox\" name=\"".$row["id"]."\" value=\"si\" /></center>
										</td>
									 </tr>\n";
						}
				  else
				  		{
                			$page .= "<tr>
									 	<td style=\"background-color:#BF6000;\">
											<a href=\"mensajero.php?do=leer:".$row["id"]."\">".$row["title"]." <img border=0 src=\"estilo/imagenes/default/mensajenuevo.jpg\"></a>
										</td>
										<td style=\"background-color:#BF6000;\">
											<a href=\"index.php?do=enlinea:".$author["id"]."\">
											 ".$author["charname"]." </a>
										</td>
										<td style=\"background-color:#BF6000;\">
											".$row["date"]."
										</td>
										<td style=\"background-color:#BF6000;\">
											<center><input type=\"checkbox\" name=\"".$row["id"]."\" value=\"si\" /></center>
										</td>
									 </tr>\n";
            			} 
				} 
		} 
		
    	$page .= "</table></td></tr></table>";
		$page .= "<table>
				<tr>
					<td><input type=\"submit\" name=\"do\" value=\"Nuevo\" /></td>
					<td><input type=\"submit\" name=\"do\" value=\"Borrar\" /></td>";
    if ($userrow["autorizacion"] == 1)
   		$page .= "<td><input type=\"submit\" name=\"do\" value=\"masivo\" /></td>";
    	$page .= "</tr></table></form></div>";
    	display($page, "Mensajero");

}


function read_mail($id) {
global $userrow, $controlrow;
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "mail");
	$update_query=doquery("UPDATE {{table}} SET estado='leyendo' WHERE destinatario='$userrow[id]' AND id='$id'", "mail");
    $row = mysql_fetch_array($query);
    
	if (!$row)
        display("<div class='contenido2'>Mensaje invalido.<br /><a href=\"javascript: history.go(-1)\">Volver</a>.</div>", "Error");
    if ($row['destinatario'] != $userrow['id'])
        die("No tienes acceso a estos mensajes. No vuelvas a intentarlo o seras baneado.");
		
    $query2 = doquery("SELECT * FROM {{table}} WHERE id='$row[remitente]'", "usuarios");
    $author = mysql_fetch_array($query2);

    $message = $row[message];

	$page = "<div class='contenido2'><table width=\"100%\">
			 <tr>
			 	<td style=\"padding:1px; background-color:black;\">
					<table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
						<tr>
							<td colspan=\"2\" style=\"background-color:#804000;\">
								<b><a href=\"mensajero.php\">Bandeja Entrada</a> :: ".$row["title"]."</b>
							</td>
						</tr>
					</table>
    				<table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
							<td width=\"50%\" style=\"background-color:#9D4F00;\">
								<b>De: <a href=\"index.php?do=enlinea:".$author["id"]."\">
								".$author["charname"]."</a></b>
							</td>
			 		</table>
					<table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
						<tr>
							<td style=\"background-color:#9D4F00; vertical-align:center;\">
								<b>Fecha envio:</b> ".$row["date"]."
							</td>
						</tr>	
					</table>
					<table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
						<tr>
							<td style=\"background-color:#9D4F00; vertical-align:center;\">
								<b>Titulo:</b> ".$row["title"]."
							</td>
						</tr>
					</table>
					<table width=\"100%\" height=\"200\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\">
						<tr>
							<td style=\"background-color:#9D4F00;\">
								".nl2br($message)."
							</td>
						</tr>
					</table>
			  	</td>
			  </tr>
			  </table><br />";
	
	$page .= "<table width=\"100%\">
			<tr>
				<td style=\"background-color:#804000; vertical-align:center;\">
					<b>Responder mensaje:</b>
				</td>
			</tr>
			<tr>
				<td style=\"background-color:#9D4F00; vertical-align:center;\">
								<form action=\"mensajero.php?do=responder:".$row["id"]."\" method=\"post\">
								<b>Titulo: </b>
								<input type=\"text\" name=\"Subject\" value=\"RE: $row[title]\" size=\"20\" maxlength=\"20\" />
				</td>
			</tr>
			</table>
			<table width=\"100%\">	          
			<tr>
				<td>
					<center><textarea name=\"Message\" rows=\"8\" cols=\"44\"></textarea><br /><br /></center>
					<center><input type=\"submit\" name=\"submit\" value=\"Enviar\" /> 
					<input type=\"reset\" name=\"reset\" value=\"Cancelar\" /></center>
								</form>
				</td>
			 </tr>
			 </table></div>";
    
    display($page, "Leer Mensaje");

}

function reply($reply) {
    global $userrow;

    $query = doquery("SELECT * FROM {{table}} WHERE id=$reply", "mail");
    $mail = mysql_fetch_assoc($query);
    $query2 = doquery("SELECT * FROM {{table}} WHERE id=".$mail['remitente']."", "usuarios");
    $mailer = mysql_fetch_assoc($query2);
    $title = "RE: ".$mail['title'];
    if ($_POST['noquote'] != true)
        $message = "[quote=".$mailer['charname']."]".$mail['message']."[/quote]<br />".$_POST['message'];
    else
        $message = $_POST['message'];
    $query = doquery("INSERT INTO {{table}} SET id='',destinatario=".$mail['remitente'].",remitente='".$userrow['id']."',title='$title',message='$message',date=NOW()", "mail");
    header("Location: mensajero.php");
    die();

}

function mass_mail() {
    global $userrow;

    if ($userrow["autorizacion"] != 1)
        header("Location: mensajero.php");
    if (isset($_POST['Message'])) {
//Miramos que el mensaje masivo contenga texto en el mensaje
        	extract($_POST);
			if ($Message == "")
				{
					display("<div class='contenido2'>Debes escribir un mensaje para poder enviarlo<br />
				     	    Por favor <a href=\"javascript: history.go(-1)\">vuelva</a> atras.", "Error");
				}
			else 	
				$Message = $_POST['Message'];    
	//Nos aseguramos que haya puesto titulo tambien
	if	(isset($_POST['title']))
			{	
				extract($_POST);
				if ($title == "")
					$title="None";
				else			
					$title = $_POST['title'];
			 }
        $oquery = doquery("SELECT * FROM {{table}}", "usuarios");
        while ($receiver = mysql_fetch_assoc($oquery))
            doquery("INSERT INTO {{table}} SET id='',destinatario=".$receiver['id'].",remitente='".$userrow['id']."',title='$title',Message='$Message',Date=NOW(), estado='sinleer'", "mail");
        header("Location: mensajero.php");
        die();
    }
    $page = "<form action=\"mensajero.php?do=masivo\" method=\"post\">
	         <div class='contenido2'><table width=\"100%\">
			 <tr>
			 	<td>
					Enviar mensaje masivo (<b>Se enviara a todos los usuarios</b>):<br /><br/ >
					Titulo:<br />
					<input type=\"text\" name=\"title\" size=\"20\" maxlength=\"20\" /><br /><br />
					Mensaje:<br /><textarea name=\"Message\" rows=\"7\" cols=\"40\"></textarea><br /><br />
					<input type=\"submit\" name=\"submit\" value=\"Enviar\" /> 
					<input type=\"reset\" name=\"reset\" value=\"Cancelar\" />
				</td>
			</tr>
			</table></div></form>";
    display($page, "Mensaje Masivo");

}
function write_mail() {
     global $userrow;

	if (isset($_POST["submit"]))
		{	
			extract($_POST);
			
//Asegurarnos de que el mensaje lleve texto
		
		if ($Message == "")
			{
				display("<div class='contenido2'>No puedes enviar un mensaje vacio.<br />
		     		    Vuelva <a href=\"javascript: history.go(-1)\">atras</a>.</div>", "Error");
			}
		else 	
			$Message = $_POST['Message'];   	
			
//Asegurarnos de que el titulo tenga texto		
			
		if ($title == "")
			$title = "None";
		else			
			$title = $_POST['title'];
					
			
//Enviar correo por usuario e id			
			
			$errors= 0;
			$errorlist = "";
			$option = "";
			
			$oquery = doquery("SELECT * FROM {{table}} WHERE charname='".$_POST['name']."' LIMIT 1", "usuarios");
    		$receiver = mysql_fetch_assoc($oquery);
		    $oquery2 = doquery("SELECT * FROM {{table}} WHERE charname='".$userrow['charname']."' LIMIT 1", "usuarios");
		    $sender = mysql_fetch_assoc($oquery2); 

     
			if ($receiver == "" & $receiver_ID =="") //Nos aseguramos de que se ponga nombre o id
		   		{
					$errors++;
					$errorlist .= "<div class='contenido2'>Debes escribir un <b>nombre</b>.<br></div>";
				}
			
			if ($receiver != "" & $receiver_ID =="")
				{
					if ($receiver == $sender) //Si el nombre del destinatario es el mismo que el remitente no dejamos enviar
					{	
					$errors++;
					$errorlist .= "<div class='contenido2'>No puedes enviar mensajes a ti mismo.</div>";
					}		
		
					$option="0";
				}
				
				
			if ($errors == 0) //Si no hay ningun error podemos empezar a enviar el mensaje
				{ 
	        		if($option==0)//Esta opcion es para enviar al nombre del personaje
						{	
							doquery("INSERT INTO {{table}} SET id='',destinatario=".$receiver['id'].",remitente='".$userrow['id']."',title='$title',Message='$Message',date=NOW(), estado='sinleer'", "mail");
        					header("Location: mensajero.php");
        					die();
						}
				}
			else //Mostramos la lista de errores
				{
					display("<div class='contenido2'>Vuelva <a href=\"javascript: history.go(-1)\">atras</a> e intentelo de nuevo.<br /><br />Error(es):<br />$errorlist</div>", "Error");
				}
		}//Terminamos el if (isset($_POST["submit"]))

   
    $page = "<form action=\"mensajero.php?do=nuevo\" method=\"post\">
			
<div class='contenido2'><b><u>Escribir mensaje</b></u><br /><br />
    <table width=\"100%\">
			<tr>
				<td>
					<b>Nombre personaje:</b><br /><input type=\"text\" name=\"name\" size=\"30\" maxlength=\"30\" /><br /><br />
					<b>Titulo:</b><br /><input type=\"text\" name=\"title\" size=\"20\" maxlength=\"20\" /><br /><br />
					<b>Mensaje:</b><br /><textarea name=\"Message\" rows=\"8\" cols=\"44\"></textarea><br /><br /><br />
					<input type=\"submit\" name=\"submit\" value=\"Enviar\" /> 
					<input type=\"reset\" name=\"reset\" value=\"Cancelar\" />
				</td>
			</tr>
			</table></div></form>";
			
    display($page, "Escribir mensaje");

}

function delete_mail($id) {
    global $userrow;

    if ($_POST['do'] == 'Nuevo') {
        header("Location: mensajero.php?do=nuevo");
        die();
    }
    if ($_POST['do'] == 'masivo') {
        header("Location: mensajero.php?do=masivo");
        die();
    }
    foreach($_POST as $a => $b) {
        if ($a != "do")
            doquery("DELETE FROM {{table}}  WHERE id={$a}", "mail");
    }
    header("Location: mensajero.php");
    die();
}


?>