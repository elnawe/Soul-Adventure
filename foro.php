<?php 
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
if ($userrow["autorizacion"] == 2){ die( //Mutear a los jugadores
"Tu cuenta ha sido baneada.<p>Para más informacion pongase en contacto con el administrador.");
}

if (isset($_GET["do"])) {
	$do = explode(":",$_GET["do"]);
	
	if ($do[0] == "thread") { showthread($do[1], $do[2]); }
    elseif ($do[0] == "editpost") { editpost($do[1]); }
	elseif ($do[0] == "new") { newthread(); }
	elseif ($do[0] == "reply") { reply(); }
	elseif ($do[0] == "delete") { delete($do[1]); }
	elseif ($do[0] == "list") { donothing($do[1]); }
	
} else { donothing(0); }

//Funcion encargada de mostrar el inicio del foro
function donothing($start=0) {

	
      $query2 = doquery("SELECT * FROM {{table}} WHERE pin='1' ORDER BY newpostdate DESC LIMIT 20", "foro");
 $page = "<div class='titulo'>Foro</div><div class='contenido2'>";
       
 $page .= "<hr /><table width=\"590px\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"4\" style=\"background-color:#000000;\"><center>Solo moderadores pueden fijar temas.</center></th></tr><tr><th width=\"44%\" style=\"background-color:#000000;\">Temas Fijos</th><th width=\"2%\" style=\"background-color:#000000;\">Respuestas</th><th  width=\"10%\" style=\"background-color:#000000;\">Autor</th><th  width=\"30%\" style=\"background-color:#000000;\">Ultimo Post</th></tr>\n";
	$count = 1;
    if (mysql_num_rows($query2) == 0) {
       $page .= "<tr><td style='background-color:#B45F04;' colspan='4'><b>No hay archivos fijados.</b></td></tr>\n";
    } else {
      while ($row = mysql_fetch_array($query2)) {
	  	if ($row["close"] != "1") {
	  		$namelink2 = "<font color=red><b>Fijos:<b/></font> ";
	  	} else {
	  		$namelink2 = "<font color=red><b>Fijos:<b/></font> ";
	  	}
		if ($count == 1) {
                $page .= "<tr><td style=\"background-color:#ffffff;\">".$namelink2."<a href=\"foro.php?do=thread:".$row["id"].":0\">".$row["titulo"]."</a></td><td style=\"background-color:#ffffff;\">".$row["respuesta"]."</td><td style=\"background-color:#ffffff;\">".$row["autor"]."</td><td style=\"background-color:#ffffff;\">".$row["newpostdate"]."</td></tr>\n";
			
		} 
	  }
    }

    $page .= "</table></td></tr></table><hr />";

$query= doquery("SELECT * FROM {{table}} WHERE tema_padre='0' AND pin!='1' ORDER BY newpostdate DESC LIMIT ".$start.",12", "foro");
$fullquery = doquery("SELECT * FROM {{table}} WHERE tema_padre='0' AND pin!='1' ORDER BY newpostdate", "foro");
 $page .= "<table width=\"100%\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><th colspan=\"4\" style=\"background-color:#FFFFFF;\"><center><a href=\"foro.php?do=new\">Crear nuevo tema</a></center></th></tr><tr><th width=\"44%\" style=\"background-color:#000000;\">Titulo</th><th width=\"2%\" style=\"background-color:#000000;\">Respuestas</th><th  width=\"10%\" style=\"background-color:#000000;\">Autor</th><th  width=\"30%\" style=\"background-color:#000000;\">Ultimo Post</th></tr>\n";
	$count = 1;
	
    if (mysql_num_rows($query) == 0) {
       $page .= "<tr><td style='background-color:#B45F04;' colspan='4'><b>No hay temas.</b></td></tr>\n";
    } else {
      while ($row = mysql_fetch_array($query)) {
	  	if ($row["close"] != "1") {
	  		$namelink = "";
	  	} else {
	  		$namelink = "<img src='imgenes/foro/padlock.gif'>";
	  	}
		if ($count == 1) {
                $page .= "<tr style=\"background-color:#B45F04;\"><td>".$namelink."<a href=\"foro.php?do=thread:".$row["id"].":0\">".$row["titulo"]."</a></td><td >".$row["respuesta"]."</td><td>".$row["autor"]."</td><td >".$row["newpostdate"]."</td></tr>\n";
		} 
	  }
    }

	$page .= "<tr><td colspan='5' style='background-color:#000000;'><center> Paginas [ "; 
    $numpages = intval(mysql_num_rows($fullquery)/12);
	for($pagenum = 0; $pagenum <= $numpages; $pagenum++) {
		$pagestart = $pagenum*12;
		$pagelink = $pagenum + 1;
		if ($start != $pagestart) {
		$page .= "<a href='foro.php?do=list:".$pagestart."'>".$pagelink."</a>   ";}
		else {
		$page .= "<i>".$pagelink."</i>   ";}
	}
	$page .= " ]</center></td></tr>";
    $page .= "</table></td></tr></table><hr />";
    $page .= "<p>Puedes volver al <a href=\"foro.php\">foro</a>, o <a href='index.php'>regresar</a> a donde estabas antes<br /></div>\n";      
    
    display($page, "Foro");
    
}
// Función encargada de mostrar los mensajes
function showthread($id, $start) {
global $controlrow, $userrow, $row; 


    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' OR tema_padre='$id' ORDER BY id LIMIT $start,50", "foro");
    $query2 = doquery("SELECT titulo FROM {{table}} WHERE id='$id' LIMIT 1", "foro");
    $row2 = mysql_fetch_array($query2);
    
 $page = "<div class='titulo'>Viendo el post ".$row2["titulo"]."</div><div class='contenido2'>";
    $page .= "<table width=\"590px\"><tr><td style=\"padding:1px; background-color:black;\"><table width=\"100%\" style=\"margins:0px;\" cellspacing=\"1\" cellpadding=\"3\"><tr><td colspan=\"2\" style=\"background-color:#B45F04;\"><b><a href=\"foro.php\">Foro</a> :: ".$row2["titulo"]."</b></td></tr>\n";
    $count = 1;
	
    while ($row = mysql_fetch_array($query)) {

		 $query3 = doquery("SELECT postcount,autorizacion,customtitle FROM {{table}} WHERE charname='".$row["autor"]."' LIMIT 1", "usuarios");
	$row3 = mysql_fetch_array($query3); 
		 $authorquery = doquery("SELECT id FROM {{table}} WHERE charname='".$row["autor"]."'", "usuarios");
	$authorrow = mysql_fetch_array($authorquery);
	//Reemplazo de los caracteres por emoticonos
				$row = str_replace(":)", "<img src='estilo/imagenes/emoticonos/smiley.gif'>", $row); 
				$row = str_replace(":D", "<img src='estilo/imagenes/emoticonos/cheese.gif'>", $row);
				$row = str_replace(";D", "<img src='estilo/imagenes/emoticonos/grin.gif'>", $row);
			    $row = str_replace(":(", "<img src='estilo/imagenes/emoticonos/sad.gif'>", $row);
				$row = str_replace(">:(", "<img src='estilo/imagenes/emoticonos/angry.gif'>", $row);
				$row = str_replace(":o", "<img src='estilo/imagenes/emoticonos/shocked.gif'>", $row);
				$row = str_replace("8)", "<img src='estilo/imagenes/emoticonos/cool.gif'>", $row);
				$row = str_replace("???", "<img src='estilo/imagenes/emoticonos/huh.gif'>", $row);
				$row = str_replace("::)", "<img src='estilo/imagenes/emoticonos/rolleyes.gif'>", $row);
		        $row = str_replace(":P", "<img src='estilo/imagenes/emoticonos/tongue.gif'>", $row);
			    $row = str_replace(";)", "<img src='estilo/imagenes/emoticonos/wink.gif'>", $row);
			    $row = str_replace("^^", "<img src='estilo/imagenes/emoticonos/rolleyes.gif'>", $row);
			    $row = str_replace(":$", "<img src='estilo/imagenes/emoticonos/embaressed.gif'>", $row);
			    $row = str_replace(":-X", "<img src='estilo/imagenes/emoticonos/lipsrsealed.gif'>", $row);
				$row = str_replace(":-|", "<img src='estilo/imagenes/emoticonos/undecided.gif'>", $row);
				$row = str_replace(":-*", "<img src='estilo/imagenes/emoticonos/kiss.gif'>", $row);
				$row = str_replace(":'(", "<img src='estilo/imagenes/emoticonos/cry.gif'>", $row);
			    $row = str_replace("joder", " <b><font color=red>******</font></b> ", $row); 
			    $row = str_replace("shit", " <b><font color=red>[Word Censored]</font></b> ", $row);
			    $row = str_replace("bastard", " <b><font color=red>[Word Censored]</font></b> ", $row); 
			    $row = str_replace("piss", " <b><font color=red>[Word Censored]</font></b> ", $row); 
			    $row = str_replace("cunt", " <b><font color=red>[Word Censored]</font></b> ", $row); 		
			    $row = str_replace("dick", " <b><font color=red>[Word Censored]</font></b> ", $row); 			    
				$row = str_replace("bitch", " <b><font color=red>[Word Censored]</font></b> ", $row); 	
			    $row = str_replace("twat", " <b><font color=red>[Word Censored]</font></b> ", $row); 
				
	$titi = $row3["customtitle"];
        if ($count == 1) {
            $page .= "<tr><td width=\"25%\" rowspan='2' style=\"background-color:#000000; vertical-align:top;\"><span class=\"small\"><b>".$row["autor"]."</b><br />".$avatar."Posts: ".$row3["postcount"]."<br />".prettyforumdate($row["postdate"])."</td><td style=\"background-color:#000000; vertical-align:top;\">".nl2br($row["mensaje"])."<br><br></td></tr><tr><td style=\"background-color:#B45F04; vertical-align:bottom;\">[<a href=\"foro.php?do=editpost:".$row["id"]."\">Editar Tema</a>]</td></tr>\n"; //MIRAR MIRAR MIRAR
          
        }
    }
    
    $page .= "</table></td></tr></table><br />";

$query = doquery("SELECT * FROM {{table}} WHERE id='$id' OR tema_padre='$id' ORDER BY id LIMIT $start,50", "foro");
$row = mysql_fetch_array($query);
if ($row["close"] == 1)  {
 $page .= "<center><img src=\"imgenes/foro/padlock.gif\"><br><b>El tema ha sido cerrado</b></center><p>";

    } else {

    $page .= "<a name=\"bottom\"></a><p><table width=\"100%\"><tr><td><b>Respuesta:</b><br /><form action=\"foro.php?do=reply\" method=\"post\"><input type=\"hidden\" name=\"parent\" value=\"$id\" /><input type=\"hidden\" name=\"title\" value=\"Re: ".$row2["titulo"]."\" /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><input type=\"submit\" name=\"submit\" value=\"Enviar\" /> <input type=\"reset\" name=\"reset\" value=\"Borrar\" /></form></td></tr></table>";

}
$page .= "Volver al <a href=\"foro.php\">foro</a><br /></div>\n";      
    
    display($page, "Foro");
    
}

//Función encargada de responder a los mensajes del foro
function reply() {

    global $userrow;
	extract($_POST);

	$query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),autor='".$userrow["charname"]."',tema_padre='$parent',respuesta='0',titulo='$title',mensaje='$content'", "foro");
	$query2 = doquery("UPDATE {{table}} SET newpostdate=NOW(),respuesta=respuesta+1 WHERE id='$parent' LIMIT 1", "foro");
        $query = doquery("UPDATE {{table}} SET postcount=postcount+1 WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
	header("Location: foro.php?do=thread:$parent:0");
	die();
	
}

//Función encargada de crear un nuevo tema.
function newthread() {

    global $userrow;

    
    if (isset($_POST["submit"])) {

        extract($_POST);

        $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),newpostdate=NOW(),autor='".$userrow["charname"]."',tema_padre='0',respuesta='0',titulo='$title',mensaje='$content'", "foro");
        $query = doquery("UPDATE {{table}} SET postcount=postcount+1 WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
         header("Location: foro.php");
        die();
    }
     $page = "<div class='titulo'>Crear nuevo post</div><div class='contenido2'><table width='100%' border='1'><tr><td class='title'>Foro - Crear tema</td></tr></table><p>";
    $page .= "<table width=\"100%\"><tr><td><b>Crear nuevo tema:</b><br /><br/ ><form action=\"foro.php?do=new\" method=\"post\">
	Titulo:<br /><input type=\"text\" name=\"title\" size=\"50\" maxlength=\"50\" /><br /><br />
	Mensaje:<br /><textarea name=\"content\" rows=\"7\" cols=\"40\"></textarea><br /><br />
	<input type=\"submit\" name=\"submit\" value=\"Enviar\" /> <input type=\"reset\" name=\"reset\" value=\"Limpiar\" /></form></td></tr></table>";
$page .= "Puedes volver al <a href=\"foro.php\">foro</a>, o usar la brujula para explorar el mapa.<br /></div>\n";      
    
display($page, "Foro");
    
}

//Función encargada de editar los mensajes
function editpost($id) {
 global $userrow;

    if (isset($_POST["submit"])) {

        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($content == "") { $errors++; $errorlist .= "Ponga algo en el mensaje.<br />"; }
       if ($title == "") { $errors++; $errorlist .= "El titulo es obligatorio.<br />"; }      
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET titulo='$title', mensaje='$content' WHERE id='$id' LIMIT 1", "foro");
            display("Tu tema ha sido posteado correctamente. Volver al <a href=\"foro.php\">foro</a>.","Edit Post");
        } else {
            display("<b>Errors:</b><br /><div style=\"color:red;\">$errorlist</div><br />Por favor vuelva e intentelo de nuevo", "Edit Post");
        }        
        
    }   
$idquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "foro");
	$idrow = mysql_fetch_array($idquery);
	if ($idrow["autor"] != $userrow["charname"]) {
        $page .= "<table width='100%' border='1'><tr><td class='title'>Foro - Denegado acceso a Editar</td></tr></table><p>";
	$page .= "No puedes editar el post! Volver al <a href='foro.php'>Foro</a>.<br>";
	display($page, "Editar Post");
	}          
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "foro");
    $row = mysql_fetch_array($query);

$page = <<<END
<table width="100%"><tr><td class="title">Editar POST/td></tr></table>
<form action="foro.php?do=editpost:$id" method="post">
<table width="90%">
<tr><td width="20%">Autor:</td><td>{{autor}} - <a href="foro.php?do=delete:$id">Borrar POST</a></td></tr>
<tr><td width="20%">Post Date:</td><td>{{postdate}}</td></tr>
<tr><td width="20%">Titulo:</td><td><input type="text" name="title" size="50" maxlength="50" value="{{titulo}}" /></td></tr>
<tr><td width="20%">Mensaje:</td><td><textarea name="content" rows="7" cols="40">{{mensaje}}</textarea></td></tr>
</table>
<input type="submit" name="submit" value="Enviar" /> <input type="reset" name="reset" value="Borrar" />
</form>
Volver al <a href="foro.php">foro</a>
END;
    
    $page = parsetemplate($page, $row);
    display($page, "Editar Post");
    
}


//Función encargada del borrado de post
function delete($id) {
	global $userrow;
	$query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "foro");
    $row = mysql_fetch_array($query);
	$query = doquery("DELETE FROM {{table}} WHERE id='$id' OR tema_padre='$id' ", "foro");
	$query = doquery("UPDATE {{table}} SET postcount=postcount-1 WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
	header("Location: foro.php");
	die();

}
	
?>