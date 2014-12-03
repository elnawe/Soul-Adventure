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

if(filesize('configuracion.php') == 0)
	{
		header( "location: instalar.php");
	}
elseif((filesize('configuracion.php') > 0) && (file_exists('instalar.php')))
	{ 
		die("Por favor, borra <b>instalar.php</b> para continuar."); 
	}
include('lib.php');
include('cookies.php');

$link = opendb();
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

// Login.
$userrow = checkcookies();
if ($userrow == false) { 
    if (isset($_GET["do"])) {
        if ($_GET["do"] == "verificar") { header("Location: usuarios.php?do=verificar"); die(); }
    }
    header("Location: entrar.php?do=entrar"); die(); 
}
// Juego Cerrado.
if ($controlrow["gameopen"] == 0) { display("<div class='contenido2'>El juego está cerrado por mantenimiento. Contactese con el administrador para más información.</div>","Juego Cerrado"); die(); }
// Forzar a verificar.
if ($controlrow["verifyemail"] == 1 && $userrow["verify"] != 1) { header("Location: usuarios.php?do=verificar"); die(); }
// Usuario baneado.
if ($userrow["autorizacion"] == 2) { die("<div class='contenido2'>Tu cuenta ha sido bloqueada. Contacta con administración para más información.</div>"); }

if (isset($_GET["do"])) {
    $do = explode(":",$_GET["do"]);
    
    // Funciones de Ciudades.
    if ($do[0] == "hotel") { include('ciudad.php'); inn(); }
    elseif ($do[0] == "comprar") { include('ciudad.php'); buy(); }
    elseif ($do[0] == "comprar2") { include('ciudad.php'); buy2($do[1]); }
    elseif ($do[0] == "comprar3") { include('ciudad.php'); buy3($do[1]); }
    elseif ($do[0] == "vender") { include('ciudad.php'); sell(); }
    elseif ($do[0] == "mapas") { include('ciudad.php'); maps(); }
    elseif ($do[0] == "mapas2") { include('ciudad.php'); maps2($do[1]); }
    elseif ($do[0] == "mapas3") { include('ciudad.php'); maps3($do[1]); }
    elseif ($do[0] == "irciudad") { include('ciudad.php'); travelto($do[1]); }
	elseif ($do[0] == "rank") { include('ciudad.php'); topten($do[1]); }
	elseif ($do[0] == "rankpvp") { include('ciudad.php'); toppvp($do[1]); }
	elseif ($do[0] == "changelog") { include('changelog.php'); changelog(); }
	elseif ($do[0] == "changelog2") { include('changelog.php'); changelog2(); }
	elseif ($do[0] == "changelog3") { include('changelog.php'); changelog3(); }
	elseif ($do[0] == "chat") { include('ciudad.php'); chat(); }
	elseif ($do[0] == "banco") { include('ciudad.php'); banco(); }
	elseif ($do[0] == "cambiar") {include('ciudad.php'); cambiarcontrasenia(); }
	 
    // Funciones de Exploración.
    elseif ($do[0] == "mover") { include('explorar.php'); move(); }
    
    // Funciones de Pelea.
    elseif ($do[0] == "pelear") { include('pelea.php'); fight(); }
    elseif ($do[0] == "victoria") { include('pelea.php'); victory(); }
    elseif ($do[0] == "soltar") { include('pelea.php'); drop(); }
    elseif ($do[0] == "muerte") { include('pelea.php'); dead(); }
    
    // Funciones Miscelaneas.
    elseif ($do[0] == "verificar") { header("Location: usuarios.php?do=verificar"); die(); }
    elseif ($do[0] == "habilidad") { include('curar.php'); healspells($do[1]); }
    elseif ($do[0] == "verpj") { showchar(); }
    elseif ($do[0] == "enlinea") { onlinechar($do[1]); }
    elseif ($do[0] == "vermapa") { showmap(); }

	// Funciones de Pvp
	elseif ($do[0] == "arena") { include('pvp.php'); menu(); }
	elseif ($do[0] == "desafiar") { include('pvp.php'); pvp(); }
	elseif ($do[0] == "desafios") { include('pvp.php'); pvp1(); }
	elseif ($do[0] == "desafiados") { include('pvp.php'); pvpenviados(); }
	elseif ($do[0] == "pvp1") { include('pvp.php'); pvp2($do[1]); }
	elseif ($do[0] == "pvp2") { include('pvp.php'); pvp3($do[1]); }
	elseif ($do[0] == "pvp3") { include('pvp.php'); pvp4($do[1]); }
	
	//Funciones de Mensajeria
	elseif ($do[0] == "mensaje") { include('mensajero.php'); mailbox(); }
	elseif ($do[0] == "enviados") { include('mensajero.php'); enviados(); }
    elseif ($do[0] == "responder") { include('mensajero.php'); reply($do[1]); }
    elseif ($do[0] == "leer") { include('mensajero.php'); read_mail($do[1]); }
    elseif ($do[0] == "nuevo") { include('mensajero.php'); write_mail(); }
    elseif ($do[0] == "masivo") { include('mensajero.php'); mass_mail(); }
    elseif ($do[0] == "borrar") { include('mensajero.php'); delete_mail($do[1]); }
	
	//Funciones de Entrenamiento
	elseif ($do[0] == "entrenar") { include('entrenar.php'); entrenar(); }
	
    
} else { donothing(); }


function donothing() {
    
    global $userrow;

    if ($userrow["currentaction"] == "En la ciudad") {
        $page = dotown();
        $title = "En la Ciudad";
    } elseif ($userrow["currentaction"] == "Explorando") {
        $page = doexplore();
        $title = "Explorando";
    } elseif ($userrow["currentaction"] == "Peleando")  {
        $page = dofight();
        $title = "Peleando";
    }
    
    display($page, $title);
    
}

function dotown() { // Página de Ciudad.
    
    global $userrow, $controlrow, $numqueries;
    
    $townquery = doquery("SELECT * FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) == 0) { display("<div class='contenido2'>Ha ocurrido un error. Por favor, reactualiza la página para intentar arreglarlo o comunicate con la administración a travez del <a href=http://www.soul-adventure.net/foro>foro</a>.</div>","Error"); }
    $townrow = mysql_fetch_array($townquery);
    
    // Noticias.
    if ($controlrow["shownews"] == 1) { 
        $newsquery = doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 1", "noticias");
        $newsrow = mysql_fetch_array($newsquery);
        $townrow["news"] = "<div class='notionliti'>Noticias</div>\n";
		setlocale(LC_TIME, ‘Spanish’);
		$fecha=$newsrow["postdate"];
		$Fecha = @strtotime($fecha); 
		$FECHA=strftime("%d de %B del %Y",$Fecha);
        $townrow["news"] .= "<span class=\"light\">".$FECHA."</span><br />".nl2br($newsrow["content"]);
        $townrow["news"] .= "";
    } else { $townrow["news"] = ""; }
    
    // Quienes estan conectados.
    if ($controlrow["showonline"] == 1) {
        $onlinequery = doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "usuarios");
        $townrow["whosonline"] = "<div class='notionliti'>Quien está conectado</div>\n";
        $townrow["whosonline"] .= "Hay <b>" . mysql_num_rows($onlinequery) . "</b> usuario(s) conectado(s) en los últimos 10 minutos: ";
        while ($onlinerow = mysql_fetch_array($onlinequery)) { $townrow["whosonline"] .= "<a href=\"index.php?do=enlinea:".$onlinerow["id"]."\">".$onlinerow["charname"]."</a>" . ", "; }
        $townrow["whosonline"] = rtrim($townrow["whosonline"], ", ");
        $townrow["whosonline"] .= "</td></tr></table>\n";
    } else { $townrow["whosonline"] = ""; }
    

    
    $page = gettemplate("ciudad");
    $page = parsetemplate($page, $townrow);
    
    return $page;
    
}

function doexplore() { // Explorando.
    
    
$page = <<<END
<div class='titulo'>Explorando</div>
<div class='contenido2'>
<table width="100%">
<tr><td>
<b>Te mueves por las frias tierras y ves que nada ocurre. Sigue explorando con los botones de movimiento o usa el Mapa de una ciudad para llegar a ella más rápidamente.</b><br /><br />
<center><img src='estilo/imagenes/default/mapa.gif'></center>
</td></tr>
</table>
</div>
END;
    return $page;
        
}

function dofight() { // Redireccionando a pelea.
    
    header("Location: index.php?do=pelear");
    
}

function showchar() {
    
    global $userrow, $controlrow;
    
    // Formateando.
    $userrow["experience"] = number_format($userrow["experience"]);
    $userrow["gold"] = number_format($userrow["gold"]);
    if ($userrow["expbonus"] > 0) { 
        $userrow["plusexp"] = "<span class=\"light\">(+".$userrow["expbonus"]."%)</span>"; 
    } elseif ($userrow["expbonus"] < 0) {
        $userrow["plusexp"] = "<span class=\"light\">(".$userrow["expbonus"]."%)</span>";
    } else { $userrow["plusexp"] = ""; }
    if ($userrow["goldbonus"] > 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(+".$userrow["goldbonus"]."%)</span>"; 
    } elseif ($userrow["goldbonus"] < 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(".$userrow["goldbonus"]."%)</span>";
    } else { $userrow["plusgold"] = ""; }
    
    $levelquery = doquery("SELECT ". $userrow["charclass"]."_exp FROM {{table}} WHERE id='".($userrow["nivel"]+1)."' LIMIT 1", "niveles");
    $levelrow = mysql_fetch_array($levelquery);
    if ($userrow["nivel"] < 99) { $userrow["siguientenivel"] = number_format($levelrow[$userrow["charclass"]."_exp"]); } else { $userrow["siguientenivel"] = "<span class=\"light\">Nada</span>"; }

    if ($userrow["charclass"] == 1) { $userrow["charclass"] = $controlrow["class1name"]; }
    elseif ($userrow["charclass"] == 2) { $userrow["charclass"] = $controlrow["class2name"]; }
    elseif ($userrow["charclass"] == 3) { $userrow["charclass"] = $controlrow["class3name"]; }
	
        if ($userrow["charrace"] == 1) { $userrow["charrace"] = $controlrow["race1name"]; }
    elseif ($userrow["charrace"] == 2) { $userrow["charrace"] = $controlrow["race2name"]; }
    elseif ($userrow["charrace"] == 3) { $userrow["charrace"] = $controlrow["race3name"]; }
	elseif ($userrow["charrace"] == 4) { $userrow["charrace"] = $controlrow["race1name"]; }
    elseif ($userrow["charrace"] == 5) { $userrow["charrace"] = $controlrow["race2name"]; }
	
    if ($userrow["difficulty"] == 1) { $userrow["difficulty"] = $controlrow["diff1name"]; }
    elseif ($userrow["difficulty"] == 2) { $userrow["difficulty"] = $controlrow["diff2name"]; }
    elseif ($userrow["difficulty"] == 3) { $userrow["difficulty"] = $controlrow["diff3name"]; }
    
    $spellquery = doquery("SELECT id,name FROM {{table}}","habilidades");
    $userspells = explode(",",$userrow["spells"]);
    $userrow["magiclist"] = "";
    while ($spellrow = mysql_fetch_array($spellquery)) {
        $spell = false;
        foreach($userspells as $a => $b) {
            if ($b == $spellrow["id"]) { $spell = true; }
        }
        if ($spell == true) {
            $userrow["magiclist"] .= $spellrow["name"]."<br />";
        }
    }
    if ($userrow["magiclist"] == "") { $userrow["magiclist"] = "Nada"; }
    
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    
    $charsheet = gettemplate("verpj");
    $page = $xml . gettemplate("minimo");
    $array = array("content"=>parsetemplate($charsheet, $userrow), "title"=>"Información del Personaje");
    echo parsetemplate($page, $array);
    die();
    
}

function onlinechar($id) {
    
    global $controlrow;
    $userquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "usuarios");
    if (mysql_num_rows($userquery) == 1) { $userrow = mysql_fetch_array($userquery); } else { display("No existe ese usuario.", "Error"); }
    
    // Formateando.
    $userrow["experience"] = number_format($userrow["experience"]);
    $userrow["gold"] = number_format($userrow["gold"]);
    if ($userrow["expbonus"] > 0) { 
        $userrow["plusexp"] = "<span class=\"light\">(+".$userrow["expbonus"]."%)</span>"; 
    } elseif ($userrow["expbonus"] < 0) {
        $userrow["plusexp"] = "<span class=\"light\">(".$userrow["expbonus"]."%)</span>";
    } else { $userrow["plusexp"] = ""; }
    if ($userrow["goldbonus"] > 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(+".$userrow["goldbonus"]."%)</span>"; 
    } elseif ($userrow["goldbonus"] < 0) { 
        $userrow["plusgold"] = "<span class=\"light\">(".$userrow["goldbonus"]."%)</span>";
    } else { $userrow["plusgold"] = ""; }
    
    $levelquery = doquery("SELECT ". $userrow["charclass"]."_exp FROM {{table}} WHERE id='".($userrow["nivel"]+1)."' LIMIT 1", "niveles");
    $levelrow = mysql_fetch_array($levelquery);
    $userrow["siguientenivel"] = number_format($levelrow[$userrow["charclass"]."_exp"]);

    if ($userrow["charclass"] == 1) { $userrow["charclass"] = $controlrow["class1name"]; }
    elseif ($userrow["charclass"] == 2) { $userrow["charclass"] = $controlrow["class2name"]; }
    elseif ($userrow["charclass"] == 3) { $userrow["charclass"] = $controlrow["class3name"]; }
    
	     if ($userrow["charrace"] == 1) { $userrow["charrace"] = $controlrow["race1name"]; }
    elseif ($userrow["charrace"] == 2) { $userrow["charrace"] = $controlrow["race2name"]; }
    elseif ($userrow["charrace"] == 3) { $userrow["charrace"] = $controlrow["race3name"]; }
	elseif ($userrow["charrace"] == 4) { $userrow["charrace"] = $controlrow["race1name"]; }
    elseif ($userrow["charrace"] == 5) { $userrow["charrace"] = $controlrow["race2name"]; }
    if ($userrow["difficulty"] == 1) { $userrow["difficulty"] = $controlrow["diff1name"]; }
    elseif ($userrow["difficulty"] == 2) { $userrow["difficulty"] = $controlrow["diff2name"]; }
    elseif ($userrow["difficulty"] == 3) { $userrow["difficulty"] = $controlrow["diff3name"]; }
    
    $charsheet = gettemplate("enlinea");
    $page = parsetemplate($charsheet, $userrow);
    display($page, "Información del Personaje");
    
}

function showmap() {
    
    global $userrow; 
    
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    
    $page = $xml . gettemplate("minimo");
    $array = array("content"=>"<center><img src='estilo/imagenes/default/mapa.gif' alt=\"Map\" /></center>", "title"=>"Mapa del Mundo");
    echo parsetemplate($page, $array);
    die();
    
}






?>