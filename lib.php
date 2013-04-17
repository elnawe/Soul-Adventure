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
include ('includes/constantes.php');
$starttime = getmicrotime();
$numqueries = 0;
$version = "Versión: 2.2 (<a href='index.php?do=changelog'>Changelog</a>)";

$build = "";

// Tomando citasmagicas.
// Ejemplo de php.net.
if (get_magic_quotes_gpc()) {

   $_POST = array_map('stripslashes_deep', $_POST);
   $_GET = array_map('stripslashes_deep', $_GET);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);

}
$_POST = array_map('addslashes_deep', $_POST);
$_POST = array_map('html_deep', $_POST);
$_GET = array_map('addslashes_deep', $_GET);
$_GET = array_map('html_deep', $_GET);
$_COOKIE = array_map('addslashes_deep', $_COOKIE);
$_COOKIE = array_map('html_deep', $_COOKIE);

function stripslashes_deep($value) {
    
   $value = is_array($value) ?
               array_map('stripslashes_deep', $value) :
               stripslashes($value);
   return $value;
   
}

function addslashes_deep($value) {
    
   $value = is_array($value) ?
               array_map('addslashes_deep', $value) :
               addslashes($value);
   return $value;
   
}

function html_deep($value) {
    
   $value = is_array($value) ?
               array_map('html_deep', $value) :
               htmlspecialchars($value);
   return $value;
   
}

function opendb() { // Abriendo conexión a base de datos.

    include('configuracion.php');
    extract($dbsettings);
    $link = mysql_connect($server, $user, $pass) or die(mysql_error());
    mysql_select_db($name) or die(mysql_error());
    return $link;

}

function doquery($query, $table) { // Abstracto de BD.
    
    include('configuracion.php');
    global $numqueries;
    $sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"] . "_" . $table, $query)) or die(mysql_error());
    $numqueries++;
    return $sqlquery;

}

function gettemplate($templatename) { // Consulta de TPS.

    $filename = "estilo/templates/" . $templatename . ".php";
    include("$filename");
    return $template;
    
}

function parsetemplate($template, $array) { // Reemplazar contenido por TPS.
    
    foreach($array as $a => $b) {
        $template = str_replace("{{{$a}}}", $b, $template);
    }
    return $template;
    
}

function getmicrotime() { // Usado para expresiones con tiempo.

    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 

}

function prettydate($uglydate) { // Cambiar formato de fecha MySQL (YYYY-MM-DD).

    return date("F j, Y", mktime(0,0,0,substr($uglydate, 5, 2),substr($uglydate, 8, 2),substr($uglydate, 0, 4)));

}

function prettyforumdate($uglydate) { // Cambiar formato de fecha MySQL (YYYY-MM-DD).

    return date("F j, Y", mktime(0,0,0,substr($uglydate, 5, 2),substr($uglydate, 8, 2),substr($uglydate, 0, 4)));

}

function is_email($email) { // Thanks to "mail(at)philipp-louis.de" from php.net!

    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));

}

function makesafe($d) {
    
    $d = str_replace("\t","",$d);
    $d = str_replace("<","&#60;",$d);
    $d = str_replace(">","&#62;",$d);
    $d = str_replace("\n","",$d);
    $d = str_replace("|","??",$d);
    $d = str_replace("  "," &nbsp;",$d);
    return $d;
    
}

function logindisplay($content, $title) { //Toma el template del login
    
    global $numqueries, $userrow, $controlrow, $starttime, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    
    $template = gettemplate("entrar");
    
	
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";

    $finalarray = array(
        "title"=>$title,
        "content"=>$content,
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;

    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

function admindisplay($content, $title) { // Finalización.
    
    global $numqueries, $userrow, $controlrow, $starttime, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    
    $template = gettemplate("admin/administracion");
    
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";

    $finalarray = array(
        "title"=>$title,
        "content"=>$content,
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;

    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

function display($content, $title, $topnav=true, $leftnav=true, $rightnav=true, $badstart=false) { // Deja abrir con explorador.
    
    global $numqueries, $userrow, $controlrow, $version, $build;
    if (!isset($controlrow)) {
        $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
        $controlrow = mysql_fetch_array($controlquery);
    }
    if ($badstart == false) { global $starttime; } else { $starttime = $badstart; }
    
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";

    $template = gettemplate("primario");
    
    if ($rightnav == true) { $rightnav = gettemplate("derecha"); } else { $rightnav = ""; }
    if ($leftnav == true) { $leftnav = gettemplate("izquierda"); } else { $leftnav = ""; }
    if ($topnav == true) { $topnav = gettemplate("superior"); } else {
        $topnav = "<a href=\"entrar.php?do=entrar\">Entrar</a> <a href=\"usuarios.php?do=registrar\">Registrarse</a> <a href=\"ayuda.php\">Ayuda</a>";
    }
    
    if (isset($userrow)) {
        
        // Actualización.
        $userquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
        unset($userrow);
        $userrow = mysql_fetch_array($userquery);
        
        // Nombre de Ciudad.
        if ($userrow["currentaction"] == "En la ciudad") {
            $townquery = doquery("SELECT * FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
            $townrow = mysql_fetch_array($townquery);
            $userrow["currenttown"] = "Bienvenido a: <b>".$townrow["name"]."</b>.<br /><br />";
        } else {
            $userrow["currenttown"] = "";
        }
        
        if ($controlrow["forumtype"] == 0) { $userrow["forumslink"] = ""; }
        elseif ($controlrow["forumtype"] == 1) { $userrow["forumslink"] = "<li><a href=\"foro.php\">Foro</a></li>"; }
        elseif ($controlrow["forumtype"] == 2) { $userrow["forumslink"] = "<li><a href=\"".$controlrow["forumaddress"]."\">Foro</a></li>"; }
		

	   //Clases
		if ($userrow["charclass"] == 1) { $userrow["charclass"] = $controlrow["class1name"]; }
		elseif ($userrow["charclass"] == 2) { $userrow["charclass"] = $controlrow["class2name"]; }
		elseif ($userrow["charclass"] == 3) { $userrow["charclass"] = $controlrow["class3name"]; }
        // Formatear info..
        if ($userrow["latitude"] < 0) { $userrow["latitude"] = $userrow["latitude"] * -1 . "º Sur"; } else { $userrow["latitude"] .= "º Norte"; }
        if ($userrow["longitude"] < 0) { $userrow["longitude"] = $userrow["longitude"] * -1 . "º Oeste"; } else { $userrow["longitude"] .= "º Este"; }
        $userrow["experience"] = number_format($userrow["experience"]);
        $userrow["gold"] = number_format($userrow["gold"]);
        if ($userrow["autorizacion"] == 1) { $userrow["adminlink"] = "<li><a href='admin/administracion.php?opcion=inicio'>Administraci&oacute;n</a></li>"; } else { $userrow["adminlink"] = ""; }
        	//  Razas
	if ($userrow["charrace"] == 1) { $userrow["charrace"] = $controlrow["race1name"]; }
	elseif ($userrow["charrace"] == 2) { $userrow["charrace"] = $controlrow["race2name"]; }
	elseif ($userrow["charrace"] == 3) { $userrow["charrace"] = $controlrow["race3name"]; }
	elseif ($userrow["charrace"] == 4) { $userrow["charrace"] = $controlrow["race4name"]; }
	elseif ($userrow["charrace"] == 5) { $userrow["charrace"] = $controlrow["race5name"]; }
	

        // Barras PV/PM/PR.

	$stathp = ceil($userrow["currenthp"] / $userrow["maxhp"] * 100); 
	$stattp = ceil($userrow["currenttp"] / $userrow["maxtp"] * 100);
	if ($userrow["maxmp"] != 0) { $statmp = ceil($userrow["currentmp"] / $userrow["maxmp"] * 100); } 
	else { $statmp = 0; }
	

    $stattable = "<table width=\"100\"><tr><td width=\"33%\">\n";
    $stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td style=\"padding:0px; width:100px; height:7px; border:solid                  0px black; vertical-align:bottom;\">\n";
	
	
	
	$stattable .= "<tr><td><b></strong>PV: </b>$userrow[currenthp] / $userrow[maxhp]</td></tr>";
	$stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr>
	              <td style=\"padding:0px; width:100px; height:7px; border:solid 1px black; vertical-align:bottom;\">\n";
				  
    	if ($stathp >= 66) 
			{ $stattable .= "<div style=\"padding:0px; width:".$stathp."px; border-top:solid 0px black;                         		  		                 	background-image:url(estilo/imagenes/barras/barra_verde.gif);\">
	    	                <img src=\"estilo/imagenes/barras/barra_verde.gif\" alt=\"\" /></div>"; 
			}

		if ($stathp < 66 && $stathp >= 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$stathp."px; border-top:solid 1px black; 					 	          	                background-image:url(estilo/imagenes/barras/barra_amarillo.gif);\">
		  	                <img src=\"estilo/imagenes/barras/barra_amarillo.gif\" alt=\"\" /></div>"; 
			}

		if ($stathp < 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$stathp."px; border-top:solid 1px black; 					        	                background-image:url(estilo/imagenes/barras/barra_rojo.gif);\">
			                <img src=\"estilo/imagenes/barras/barra_rojo.gif\" alt=\"\" /></div>"; 
			}

		
		$stattable .= "<tr><td><b>PM: </b>$userrow[currentmp] / $userrow[maxmp]</td></tr>";
    	$stattable .= "<table cellspacing=\"0\" cellpadding=\"0\"><tr>
	              <td style=\"padding:0px; width:100px; height:7px; border:solid 1px black; vertical-align:bottom;\">\n";
			
				  
        if ($statmp >= 66) 
			{ $stattable .= "<div style=\"padding:0px; width:".$statmp."px; border-top:solid 0px black; 																										                            background-image:url(estilo/imagenes/barras/barra_verde.gif);\">
			                <img src=\"estilo/imagenes/barras/barra_verde.gif\" alt=\"\" /></div>"; 
			}
			
        if ($statmp < 66 && $statmp >= 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$statmp."px; border-top:solid 1px black; 	                             background-image:url(estilo/imagenes/barras/barra_amarillo.gif);\">
			                 <img src=\"estilo/imagenes/barras/barra_amarillo.gif\" alt=\"\" /></div>"; 
			}
        
		if ($statmp < 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$statmp."px; border-top:solid 0px black;                            background-image:url(estilo/imagenes/barras/barra_rojo.gif);\">
                			<img src=\"estilo/imagenes/barras/barra_rojo.gif\" alt=\"\" /></div>"; 
			}
        


		$stattable .= "<tr><td><b>PR: </b>$userrow[currenttp] / $userrow[maxtp]</td></tr>";
        $stattable .= "<table cellspacing=\"0\" cellpadding=\"0\">
		              <tr><td style=\"padding:0px; width:100px; height:7px; border:solid 1px black; vertical-align:bottom;\">\n";
					  
					  
        if ($stattp >= 66)
			 { $stattable .= "<div style=\"padding:0px; width:".$stattp."px; border-top:solid 0px black;                             background-image:url(estilo/imagenes/barras/barra_verde.gif);\">
		                     <img src=\"estilo/imagenes/barras/barra_verde.gif\" alt=\"\" /></div>"; 
		     }
			 
        if ($stattp < 66 && $stattp >= 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$stattp."px; border-top:solid 0px black;                            background-image:url(estilo/imagenes/barras/barra_amarillo.gif);\">
			                <img src=\"estilo/imagenes/barras/barra_amarillo.gif\" alt=\"\" /></div>"; 
			}
			
        if ($stattp < 33) 
			{ $stattable .= "<div style=\"padding:0px; width:".$stattp."px; border-top:solid 0px black;                            background-image:url(estilo/imagenes/barras/barra_rojo.gif);\">
			                <img src=\"estilo/imagenes/barras/barra_rojo.gif\" alt=\"\" /></div>"; 
	        }
			
		

		$stattable .= "</td></tr></table></td>\n";
        $stattable .= "</table>\n";
        $userrow["statbars"] = $stattable;
        // Haciendo números.
        if ($userrow["currenthp"] <= ($userrow["maxhp"]/5)) { $userrow["currenthp"] = "<blink><span class=\"highlight\"><b>*".$userrow["currenthp"]."*</b></span></blink>"; }
        if ($userrow["currentmp"] <= ($userrow["maxmp"]/5)) { $userrow["currentmp"] = "<blink><span class=\"highlight\"><b>*".$userrow["currentmp"]."*</b></span></blink>"; }

        $spellquery = doquery("SELECT id,name,type FROM {{table}}","habilidades");
        $userspells = explode(",",$userrow["spells"]);
        $userrow["magiclist"] = "";
        while ($spellrow = mysql_fetch_array($spellquery)) {
            $spell = false;
            foreach($userspells as $a => $b) {
                if ($b == $spellrow["id"] && $spellrow["type"] == 1) { $spell = true; }
            }
            if ($spell == true) {
                $userrow["magiclist"] .= "<a href=\"index.php?do=habilidad:".$spellrow["id"]."\">".$spellrow["name"]."</a><br />";
            }
        }
        if ($userrow["magiclist"] == "") { $userrow["magiclist"] = "Nada"; }
        
        // Lista de Viaje.
        $townslist = explode(",",$userrow["towns"]);
        $townquery2 = doquery("SELECT * FROM {{table}} ORDER BY id", "ciudades");
        $userrow["townslist"] = "";
        while ($townrow2 = mysql_fetch_array($townquery2)) {
            $town = false;
            foreach($townslist as $a => $b) {
                if ($b == $townrow2["id"]) { $town = true; }
            }
            if ($town == true) { 
                $userrow["townslist"] .= "<a href=\"index.php?do=irciudad:".$townrow2["id"]."\">".$townrow2["name"]."</a><br />\n"; 
            }
        }
        
    } else {
        $userrow = array();
    }

    $finalarray = array(
        "dkgamename"=>$controlrow["gamename"],
        "title"=>$title,
        "content"=>$content,
        "rightnav"=>parsetemplate($rightnav,$userrow),
        "leftnav"=>parsetemplate($leftnav,$userrow),
        "topnav"=>parsetemplate($topnav,$userrow),
        "totaltime"=>round(getmicrotime() - $starttime, 4),
        "numqueries"=>$numqueries,
        "version"=>$version,
        "build"=>$build);
    $page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
    
    if ($controlrow["compression"] == 1) { ob_start("ob_gzhandler"); }
    echo $page;
    die();
    
}

?>