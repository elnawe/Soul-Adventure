<?php
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribuci�n de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para m�s informaci�n: www.soul-adventure.net							#
# *                                                          				#
#############################################################################

//Poner clan privado o publico al crear, mirar para poner si es publico o privado a una pagina a otra.
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
// Bloquear usuario si est� baneado.
if ($userrow["autorizacion"] == 2) { die("Tu cuenta ha sido bloqueada."); }

//Comprobar si el jugador esta en la ciudad, si no esta no deja ver el clan
 $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("<p><div class='contenido2'>Solo se puede acceder al clan desde la ciudad. Puedes volver a <a href=\"index.php\">Explorar</a>.</div>", "Error"); }
    $townrow = mysql_fetch_array($townquery);
	
// Menu clan
if (isset($_GET["do"])) {
	$do = explode(":",$_GET["do"]);

	
    if ($do[0] == "crear") { docrear($do[1]); }
	elseif ($do[0] == "listaclanes") { dolistaclanes($do[1]); }
        elseif ($do[0] == "bancoclan") { dobanco(); }
	elseif ($do[0] == "abandonaclan") { doabandona(); }
	elseif ($do[0] == "entrarclan") { doentrando($do[1]); }
	elseif ($do[0] == "entrarpassword") { doentrarpassword($do[1]); }
	elseif ($do[0] == "listademiembros") { dolistademiembros($do[1]); }
	
	} else { menuclan(); }
	
//Si eres miembro de un clan

function menuclan() {
	global $userrow;

  	$page = "<div class='titulo'>Clan</div>";

if (($userrow["nombreclan"] != "") && ($userrow["nombreclan"] != "NULL")) { 
	
	    $gquery = doquery("SELECT * FROM {{table}} WHERE nombre='".$userrow["nombreclan"]."' LIMIT 1", "clan");
	$grow = mysql_fetch_array($gquery); 
	
$page .= <<<END
<div class='contenido2'><p>Bienvenido a la embajada de tu clan<p> 
<table>
<tr><th>Menu Clan:</th></tr>
<tr><td>
<ul>
<li><a href="clan.php?do=listademiembros">Lista Miembros</a></li>
<li><a href="clan.php?do=bancoclan">Banco del clan</a></li>
<li><a href="clan.php?do=abandonaclan">Salir del clan</a></li>
</ul>
<a href='index.php'>Volver a la ciudad</a>
</td></tr>

</table>
</div>
END;

}else {  //Si no eres un miembro de ningun clan saldra este menu

$page .= "
<div class='contenido2'>
<p>Bienvenido al menu del clan aqui podras crear un clan o entrar en uno ya disponible<p>
<table>
<tr><td>
<ul>
<li /><a href='clan.php?do=listaclanes'>Ver clanes</a>
<li /><a href='clan.php?do=crear'>Crear clan</a>
</ul>
</td></tr>
<tr><td><a href='index.php'>Volver a la ciudad</a>
</table>
</div>
";
}
    display($page,"Menu Clan");
}

function docrear() { //Crear clan
	global $userrow;
	$gquery = doquery("SELECT * FROM {{table}} WHERE nombre='".$userrow["nombreclan"]."' ", "clan"); 

	$grow = mysql_fetch_array($gquery);
	
		if ($userrow["nombreclan"] != '') { //Si un miembro ya tiene clan
		$page = "<div class='titulo'>Ya estas en un clan</div>";
		$page .= "<div class='contenido2'><p>Debes salirte de &eacute;l para crear tu propio clan.";
		$page .= "<p>Pincha para volver al <a href='clan.php'>Menu de clan</a>.</div>";
		display($page, "Crear clan");
		}
		
		if ($userrow["gold"] <= Oroclan) { 
		
		$page = "<div class='titulo'>No tienes suficiente oro</div>";
		$page .= "<div class='contenido2'>Necesitas ".Oroclan." de oro para crear un clan.";
		$page .= "<p>Volver al <a href='clan.php'>men&uacute; del clan</div>.";
		display($page, "Crear Clan");
		
		 } else {
    
		$page = "<div class='titulo'>Crear clan</div>";
		$page .= "<div class='contenido2'><p>Aqui podras editar el perfil de tu clan.";
		$page .= "<table width='100%' border='0'>";
		$page .= "<tr><td><form action='clan.php?do=crear' method='POST'>";
		$page .= "<b>Detalles del clan:</b><hr></td></tr>";
		$page .= "<tr><td>Nombre clan:<br>";
		$page .= "<input type='text' size='15' maxlength='30' name='nombre'> <i>Tu nombre del clan</i><br>";
		$page .= "<tr><td><hr></td></tr>";
		$page .= "<tr><td>Tag Clan (Max 3 Letras):<br>";
		$page .= "<input type='text' size='5' maxlength='3' name='tag'> <i>Tu tag del clan.</i><br>";
		$page .= "<tr><td><hr></td></tr>";
		$page .= "<tr><td>Precio de entrada:<br>";
		$page .= "<input type='text' size='5' maxlength='8' name='coste'> <i>Precio en oro para entrar a tu clan.</i><br>";
		$page .= "<tr><td><hr></td></tr>";
		$page .= "<tr><td>Contrase&ntilde;a clan:<br>";
		$page .= "<input type='text' size='10' maxlength='15' name='password'> <i>Password para entrar al clan</i><br>";
		$page .= "<tr><td><hr></td></tr>";
		$page .= "<textarea name=\"descripcion\" rows=\"5\" cols=\"30\"></textarea> <i>Una peque&ntilde;a descripcion acerca de tu clan.</i><br>";
		$page .= "<tr><td><hr></td></tr>";
                $page .= "<tr><td>Privacidad del clan:<br>";
		$page .= "<select name='privacidad'><option value='0'>P&uacute;blico</option><option value='1'>Privado</option></select>";
		$page .= "<tr><td><input type='submit' name='submit' value='Crear clan'></form>";
		$page .= "</td><td><form action='clan.php'>";
		$page .= "</form></td></tr></table><p>Puedes volver al <a href='clan.php'>men&uacute; del clan</a>, si has cambiado de idea.</div>";
    
    if (isset($_POST["submit"])) {

        extract($_POST);
    
    		
$page = "<table width='100%'><tr><td class='titulo'>Crear clan</td></tr></table>";
            
       
         if ($privacidad == 0)
                    {
                $query = doquery("INSERT INTO {{table}} SET nombre='$nombre', tag='$tag',descripcion='$descripcion', coste='$coste', fundador='".$userrow["charname"]."',miembros='1', privado='0', rango='1' ", "clan");
	$actualizooro = $userrow["gold"] - Oroclan; //Comprobar ORO CLAN
	$query = doquery("UPDATE {{table}} SET gold='$actualizooro', nombreclan='$nombre' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
                    $page .= "<div class='contenido2'><p>Tu clan se creo satisfactoriamente, <b>".$userrow["nombreclan"].".</p> ";
	$page .= "<center><br><a href='clan.php'>Volver al men&uacute; del clan</a></center></div>";

                    }
           elseif (($privacidad == 1) && ($password == ""))
               {
                $page.= "<div class='contenido2'><p>Tu clan ser&aacute; privado, es necesario completar el campo contrase&ntilde;a.</p> ";
                $page .= "<center><br><a href='clan.php'>Volver al men&uacute; del clan</a></center></div>";
               }
           else {
               $query = doquery("INSERT INTO {{table}} SET nombre='$nombre', tag='$tag', password='$password', descripcion='$descripcion', coste='$coste', fundador='".$userrow["charname"]."', miembros='1',privado='1', rango='1' ", "clan");
	$actualizooro = $userrow["gold"] - Oroclan; //Comprobar ORO CLAN
	$query = doquery("UPDATE {{table}} SET gold='$actualizooro', nombreclan='$nombre' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
        $page .= "<div class='contenido2'><p>Tu clan se creo satisfactoriamente, <b>".$userrow["nombreclan"]."</b>. ";
	$page .= "<center><br><a href='clan.php'>Volver al men&uacute; del clan</a></center></div>";
               }

     
	
	display($page,"Crear clan");
    	}  
    
    }
    display($page,"Crear clan");     
}

function doabandona() { //Abandonar clan
	global $userrow;
    if (isset($_POST["submit"])) {

        $fundador=doquery("SELECT * FROM {{table}} where nombre='".$userrow['nombreclan']."'", "clan");
        $comprobado = mysql_fetch_array($fundador);
        if($userrow['charname'] == $comprobado['fundador'])
            {
            $actualizar=doquery("Update {{table}} set nombreclan='' where nombreclan='".$comprobado['nombre']."'","usuarios");
            $borrar=doquery("delete from {{table}} where nombre='".$comprobado['nombre']."'","clan");
        }
        else
            {
            $actualizar=doquery("Update {{table}} set nombreclan='' where id='".$userrow['id']."'","usuarios");
            $actualizoclan=doquery("Update {{table}} set miembros=miembros-1 where nombre='".$comprobado['nombre']."'","clan");
				$content = "El usuario ".$userrow['charname']." ha abandonado tu clan.<br>\n";

				$subject = "Abandono del clan";

					$selectid=doquery("select * from {{table}} where charname='".$comprobado['fundador']."'", "usuarios");
	$seleccionado = mysql_fetch_assoc($selectid);
	$query = doquery("INSERT INTO {{table}} SET date=NOW(),remitente='Sistema',destinatario='".$seleccionado['id']."',title='Abandono del clan',message='".$content."', estado='sinleer' ", "mail");
        }
	
        $title = "Salir del clan";
		$page = "<div class='titulo'>Salir del clan</div><div class='contenido2'>";
        $page .= "<table width=\"100%\"><tr><td><b>Clan abandonado.</b></td></tr></table>";
        $page .= "Has salido del clan ".$userrow["nombreclan"]." Guild.<br>";
        $page .= "<br />Puedes volver al <a href='clan.php'>Menu del Clan</a>,";
        $page .= " o salir y ";
        $page .= "continuar explorando por el mapa.</div>";
  
    } elseif (isset($_POST["cancel"])) {

        header("Location: clan.php"); die();

    } else {

	$title = "Abandonar el clan";
	$page = "<div class='titulo'>Abandonar clan</div>";
	$page .= "<div class='contenido2'>";
	$page .= "&iquest;Estas seguro de que quieres abandonar tu clan ".$userrow["nombreclan"]."?<p>";
	$page .= "<form action='clan.php?do=abandonaclan' method='post'>\n";
	$page .= "<input type='submit' name='submit' value='Si' />  \t";
	$page .= "<input type='submit' name='cancel' value='No' />\n";
	$page .= "</form></div>\n";
	}
		display($page,"Abandonar clan");

}

function dolistaclanes($start) { //Lista clanes
	global $userrow;
	
	
	if ($start == '') {$start = 0;}
	$page = "<div class='titulo'>Lista de clanes</div><div class='contenido2'>";
	$page .= "Para unirte a un clan pulsa sobre su nombre teniendo en cuenta que tienes suficiente oro para pagar la cuota de entrada.<br>";
	$page .= "El fundador del clan sera avisado de tu entrada al clan<br>";
	$page .= "El oro sera guardado en el banco del clan para futuras mejoras del clan<br>";

	$query = doquery("SELECT * FROM {{table}} WHERE 1 ORDER BY nombre LIMIT ".$start.",20", "clan");
	$fullquery = doquery("SELECT * FROM {{table}} WHERE 1 ORDER BY nombre", "clan");
 $page .= "<hr /><table width=\"100%\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"6\" style=\"background-color:#B45F04;\"><br><center>Lista de clanes<p></center></th></tr><tr><th width='30%' style='background-color:#00000;'>Nombre</th><th width=\"15%\" style='background-color:#000000;'>Fundador</th><th width=\"5%\" style='background-color:#000000;'>Tag</th><th width='2%' style='background-color:#000000;'>Miembros</th><th width='8%' style='background-color:#000000;'>Coste</th></tr>\n";
	$count = 1;
	
	
    if (mysql_num_rows($query) == 0) {
       $page .= "<tr><td style='background-color:#B45F04;' colspan='6'><b>No existen clanes.</b></td></tr>\n";
    } else {
      while ($row = mysql_fetch_array($query)) {
	  	if ($row["privado"] == "0") {
	  		$nombreclan = "<b><a href='clan.php?do=entrarclan:".$row["id"]."'>".$row["nombre"]."</a></b>";
	  	} 
                elseif($row["privado"] == "1") {
	  		$nombreclan = "<b><img src=\"estilo/imagenes/default/clanprivado.gif\"><a href='clan.php?do=entrarpassword:".$row["id"]."'>".$row["nombre"]."</a></b>"; 
	  	}
		if ($count == 1) {
          	$page .= "<tr><td style='background-color:#B45F04;'>".$nombreclan."</td><td style='background-color:#B45F04;'>".$row["fundador"]."</td><td style='background-color:#B45F04;'>".$row["tag"]."</td><td style='background-color:#B45F04;'>".$row["miembros"]."</td><td style='background-color:#B45F04;'>".$row["coste"]."</td><tr>\n";
			$count = 2;
		} else {
            	$page .= "<tr><td style='background-color:#B45F04;'>".$nombreclan."</td><td style='background-color:#B45F04;'>".$row["fundador"]."</td><td style='background-color:#B45F04;'>".$row["tag"]."</td><td style='background-color:#B45F04;'>".$row["miembros"]."</td><td style='background-color:#B45F04;'>".$row["coste"]."</td><tr>\n";
			$count = 1;
		}
	  }
    }
	$page .= "<tr><td colspan='6' style='background-color:#000000;'><center> Paginas [ ";
   	$numpages = intval(mysql_num_rows($fullquery)/20);
	for($pagenum = 0; $pagenum <= $numpages; $pagenum++) {
	$pagestart = $pagenum*20;
	$pagelink = $pagenum + 1;
	if ($start != $pagestart) {
		$page .= "<a href='clan.php?do=entrar:".$pagestart."'>".$pagelink."</a>   ";
	}else {
		$page .= "<i>".$pagelink."</i>   ";
	}
	}
	$page .= " ]</center></td></tr>";
	$page .= "<tr><td colspan='6' style='background-color:#B45F04;'><center>";
	$page .= "Los clanes con una <img src=\"estilo/imagenes/default/clanprivado.gif\"> tienen contrase�a.<br>El limite de jugadores por clan es de 12.";
	$page .= "</center></td></tr></table></table>";
	$page .= "<center><br><a href='clan.php'>Volver</a></center></div>";
    display($page,"Lista de clanes");
}

function dolistademiembros ($filter) { //Mostrar la lista de miembros del clan
	global $userrow;
	
	if (!isset($filter)) { $filter = "";}
	$page = "<div class='titulo'>Lista de miembros</div>";
	$charquery = doquery("SELECT * FROM {{table}} WHERE charname LIKE '".$filter."%' AND nombreclan='".$userrow["nombreclan"]."' ORDER by charname", "usuarios"); 
      
	$page .= "<div class='contenido2'><center><table width='590px' style='no-border' cellspacing='0' cellpadding='3'>";
	$page .= "<tr><td colspan=\"8\" bgcolor=\"#9F5000\"><center><b>Miembros del clan: ".mysql_num_rows($charquery)."</center></td></tr>";
	$page .= "<tr><td ><b>Nombre</b></td><td><b>Ultima vez online</b></td><td><b>Oro</b></td><td><b>Oro Banco</b></td><td><b>Nivel</b></td></tr>";
	$count = 2;
	$rankquery = doquery("SELECT * FROM {{table}} WHERE nombre='".$userrow["nombreclan"]."' LIMIT 1", "clan");
	$rankrow = mysql_fetch_array($rankquery);
	
	
	while ($charrow = mysql_fetch_array($charquery)) {

		if ($count == 1) { $color = "bgcolor='#CC6600'"; $count = 2; }
		else { $color = "bgcolor='#D56A00'"; $count = 1;}
		$page .= "<tr><td ".$color." width='15%'>";
		if ($userrow["guildrank"] >= 100) {
		$page .= "".$charrow["charname"]."";}
		else {
		$page .= $charrow["charname"];}
		$page .= "</td>";
		$page .= "<td ".$color." width='25%'>".$charrow["onlinetime"]."</td>";
		$page .= "<td ".$color." width='10%'>".$charrow["gold"]."</td>";
		$page .= "<td ".$color." width='10%'>".$charrow["banco"]."</td>";
		$page .= "<td ".$color." width='5%'>".$charrow["nivel"]."</td>";
		$page .= "<td ".$color." width='5%'>".$rank."</td>";
	  	$page .= "</tr>";
	}
	$page .= "</table></center>";
	$page .= "<center><br><a href='clan.php'>Volver al menu del clan</a></center></div>";

	display($page, "Miembros del clan");

}

function doentrando($guildid) { //Entrar al clan
	global $userrow;

	$joinquery = doquery("SELECT * FROM {{table}} WHERE id='".$guildid."' LIMIT 1", "clan");
        $joinrow = mysql_fetch_assoc($joinquery);
	$gquery = doquery("SELECT miembros FROM {{table}} WHERE id='".$guildid."' LIMIT 1", "clan");
	$grow = mysql_fetch_array($gquery);

	if ($grow["miembros"] >= Maximomclan) {
		$page = "<div class='titulo'>Clan Lleno</div>";
		$page .= "<div class='contenido2'><p>El clan ha alcanzado los ".Maximomclan." miembros maximos por clan<br>";
		$page .= "<br>Volver a la <a href='index.php'>ciudad</a></div>";
    	display($page,"Clan Lleno");
	}
        if ($userrow["gold"] < $joinrow["coste"])
            {
                $page .="<table width=\"100%\"><tr>
                <div class='titulo'>Entrar al clan</div></tr></table><div class='contenido2'>
                No tienes el suficiente oro para entrar al clan ".$joinrow["nombre"].".<br /><br>
                  Volver a la <a href='index.php'>ciudad</a>.</div>";
                 display($page,"No tienes suficiente oro"); die();
              }

    if (isset($_POST["submit"])) {
	$coste = $_POST["joincost"];
	$oronuevo1 = $userrow["gold"] - $coste;
	$nombreclan = $_POST["name"];
	$guildid = $_POST["id"];
	$fundador = $_POST["founder"];
        $nuevomiembro = doquery("UPDATE {{table}} SET gold='$oronuevo1',nombreclan='$nombreclan' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");

    $precioentrada=$coste;
    $preciototal=$joinrow['bancoclan']+$precioentrada;
    $actualizoclan=doquery("Update {{table}} set miembros=miembros+1, bancoclan='".$preciototal."' where nombre='".$joinrow['nombre']."'","clan");
	
	
		$content = "Un nuevo miembro ha accedido a tu clan!<br>\n";
					$content .= "Un nuevo miembro a ingresado a tu clan ".$joinrow["nombre"]."<br>\n";
					$content .= "<u><b>Informaci&oacute;n</b></u><br>";
					$content .= "<b>Nombre de usuario:  ".$userrow["charname"]."<br>";
					$content .= "<b>Nivel: ".$userrow["nivel"]."<br>";
					$content .= "<b>Oro: ".$userrow["gold"]."<br>";


					$subject = "Nuevo miembro";
	$selectid=doquery("select * from {{table}} where charname='".$joinrow['fundador']."'", "usuarios");
	$seleccionado = mysql_fetch_assoc($selectid);
	$query = doquery("INSERT INTO {{table}} SET date=NOW(),remitente='Sistema',destinatario='".$seleccionado['id']."',title='Nuevo miembro',message='".$content."', estado='sinleer' ", "mail");

    
	$title = "Entrar al clan";
	$page = "<div class='titulo'>Entrar al clan.</div></tr>";
	$page .= "<div class='contenido2'>Ya eres un miembro oficial del clan ".$guildname.".<br />";
	$page .= "<br />Ahora puedes acceder a tu <a href='clan.php'>Clan</a>,";
	$page .= " o ir ";
	$page .= "<a href='index.php'>a la ciudad</a>.</div>";

    } elseif (isset($_POST["cancel"])) {
        header("Location: clan.php?do=listaclanes"); die();

    } else {

	$gquery = doquery("SELECT miembros FROM {{table}} WHERE id='".$guildid."' LIMIT 1", "clan");
	$grow = mysql_fetch_array($gquery);
	if ($grow["miembros"] >= 12) {
		$page = "<table width='100%'><tr><td class='titulo'>Clan Lleno</td></tr></table>";
		$page .= "<p>El clan ha alcanzado los 12 miembros maximos por clan<br>";
		$page .= "<br>Volver a la <a href='index.php'>ciudad</a>";
    	display($page,"Clan Lleno");
	}
	$title = "Entrar al clan";
	$page = "<table width='100%'><tr><div class='titulo'>Entrar al clan</div></tr></table>";
	$page .= "<div class='contenido2'>Estos son los requisitos para entrar al clan ".$joinrow["nombre"]." :<br />";
	$page .= "<i>".$joinrow["descripcion"]."</i><br><br>\n";
	$page .= "Entrar al clan te costara <b>" . $joinrow["coste"] . " de oro</b>.";
	$page .= "<p>Actualmente tienes <b>".$userrow["gold"]."</b> de oro.<br>";
	$page .= "&iquest;Continuar?<br /><br />\n";
	$page .= "<form action='clan.php?do=entrarclan:".$guildid."' method='post'>\n";
	$page .= "<input type='submit' name='submit' value='Si' />";
	$page .= "<input type='hidden' name='joincost' value='".$joinrow["coste"]."' />";
	$page .= "<input type='hidden' name='name' value='".$joinrow["nombre"]."' />";
	$page .= "<input type='hidden' name='guildid' value='".$joinrow["id"]."' />";
	$page .= " <input type='hidden' name='founder' value='".$joinrow["fundador"]."' />";
	$page .= "<input type='submit' name='cancel' value='No' />\n";
	$page .= "</div></form>\n";
	}
		display($page,"Menu Clan");
}

function doentrarpassword($guildid) {
	global $userrow;

	$joinquery = doquery("SELECT * FROM {{table}} WHERE id='".$guildid."' LIMIT 1", "clan");
    $joinrow = mysql_fetch_array($joinquery);

    if (isset($_POST["submit"])) {
		$password = $joinrow["password"];
		$passwordescrita = $_POST["contrasenia"];
		
			if ($password != $passwordescrita) 
				{
					$title = "Entrando al clan";
					$page = "<table width=\"100%\"><tr><div class='titulo'>Error</div></tr></table>";
					$page .= "<div class='contenido2'><h4>Contrase&ntilde;a incorrecta!</h4>";
					$page .= "<br />Volver al<a href='clan.php'>Clan</a>,";
					$page .= " o ";
					$page .= "<a href='index.php'>a la ciudad</a>.</div>";
				display($page, $title);
				} 
		if ($password == $passwordescrita) 
				{
					$title = "Joining a Guild";
					$page = "<table width=\"100%\"><tr><div class='titulo'>Joining a Guild</div></tr></table>";
					$page .= "<div class='contenido2'>Ya eres un miembro oficial de ".$nombreclan." Guild.<br />";
					$page .= "<br />Regresar a la pagina del  <a href='clan.php'>Clan</a>,";
					$page .= " or leave and ";
					$page .= "<a href='index.php'>return to town</a>.</div>";
                                        $miembronuevo=$joinrow['miembros']+1;
					 $nuevomiembro = doquery("UPDATE {{table}} SET gold='$oronuevo1',nombreclan='$nombreclan' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");

					$precioentrada=$coste;
					$preciototal=$joinrow['bancoclan']+$precioentrada;
					$actualizoclan=doquery("Update {{table}} set miembros=miembros+1, bancoclan='".$preciototal."' where nombre='".$joinrow['nombre']."'","clan");

					$content = "Un nuevo miembro ha accedido a tu clan!<br>\n";
					$content .= "Un nuevo miembro a ingresado a tu clan ".$joinrow["nombre"]."<br>\n";
					$content .= "<u><b>Informaci&oacute;n</b></u><br>";
					$content .= "<b>Nombre de usuario:  ".$userrow["charname"]."<br>";
					$content .= "<b>Nivel: ".$userrow["nivel"]."<br>";
					$content .= "<b>Oro: ".$userrow["gold"]."<br>";


					$subject = "Nuevo miembro";

					$selectid=doquery("select * from {{table}} where charname='".$joinrow['fundador']."'", "usuarios");
	$seleccionado = mysql_fetch_assoc($selectid);
	$query = doquery("INSERT INTO {{table}} SET date=NOW(),remitente='Sistema',destinatario='".$seleccionado['id']."',title='Nuevo miembro',message='".$content."', estado='sinleer' ", "mail");
					
					
				}
	}
	elseif (isset($_POST["cancel"])) {
        header("Location: clan.php?do=listaclanes"); die();

    } else {
	$title = "Entrando al clan";

	$page = "<table width='100%'><tr><div class='titulo'>Joining a Guild</div></tr></table>";
	$page .= "<div class='contenido2'>";
	$page .= "Escribe aqu&iacute; la contrase&ntilde; que te han proporcionado para entrar al caln</b>.";
	$page .= "<br /><br />\n";
	$page .= "<form action='clan.php?do=entrarpassword:".$joinrow["id"]."' method='post'>\n";
	$page .= "Contrase&ntilde;a: <input type='text' size='15' name='contrasenia' />";
	$page .= " <input type='submit' name='submit' value='Entrar' /><br>";
	$page .= "<input type='submit' name='cancel' value='Cancelar' />\n";
	$page .= "</form>\n</div>";

	}

		display($page,"Entrar al clan");
}

function dobanco()
    {
    global $userrow;
	 $clan=doquery("select * from {{table}} where nombre='".$userrow['nombreclan']."'", "clan") or die(mysql_error());
            $clan2=mysql_fetch_array($clan);
        if(isset($_POST['submit']))
            {
            extract($_POST);

            $subiroro=$clan2['bancoclan']+$dinero;
            $oronuevo=$userrow['gold']-$dinero;
            $actualizarbanco=doquery("update {{table}} set bancoclan='".$subiroro."' where nombre='".$userrow['nombreclan']."'","clan");
            $actualizarusuario=doquery("update {{table}} set gold='".$oronuevo."' where id='".$userrow['id']."'","usuarios");
            $title = "Dinero ingresado";
	$page = "<div class='titulo'>Dinero ingresado correctamente</div></tr>";
	$page .= "<div class='contenido2'>Tu colaboracion har&aacute; que tu clan pueda crecer.<br />";
	$page .= "<br />Ahora puedes volver al menu del<a href='clan.php'>Clan</a>,";
	$page .= " o ir ";
	$page .= "<a href='index.php'>a la ciudad</a>.</div>";

        }
        elseif(isset($_POST['cancel']))
            {
            header("Location: clan.php"); die();
        }

        else
            {

            $title = "Banco del clan";

        $page = "<div class='titulo'>Banco del clan</div>";
	$page .= "<div class='contenido2'>";
	$page .= "Aqu&iacute; podras ingresar dinero en tu clan.<b>.";
     $page .= "Actualamente tu clan dispones de ".$clan2['bancoclan']." de oro.<b>";
	$page .= "<form action='clan.php?do=bancoclan' method='post'>\n";
	$page .= "Cantidad a ingresar: <input type='text' size='15' name='dinero' />";
	$page .= " <input type='submit' name='submit' value='Ingresar' /><br>";
	$page .= "<input type='submit' name='cancel' value='Cancelar' />\n";
	$page .= "</form>\n</div>";


        }
    display($page,$title);
}
?>
	